<?php
/**
 * RJS Data Importer (Corrected with Hashing Logic & Duplicate Prevention)
 */

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'temple';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
$conn->set_charset("utf8mb4");

$dir = __DIR__ . '/downloads';

function get_hashed_name($url) {
    if (!$url || $url == "#" || strpos($url, "javascript:") === 0) return "";
    $base_url = "https://rajasthanjainsabha.in/";
    
    if (strpos($url, 'http') === 0) {
        $full_url = $url;
    } else {
        $full_url = $base_url . ltrim($url, '/');
    }
    
    $url_parts = explode('?', $full_url);
    $url_clean = $url_parts[0];
    $ext = pathinfo($url_clean, PATHINFO_EXTENSION);
    if (!$ext) $ext = "jpg";
    
    return substr(md5($full_url), 0, 12) . "." . $ext;
}

echo "--- Cleaning Database ---\n";
$conn->query("SET FOREIGN_KEY_CHECKS = 0");
$conn->query("TRUNCATE com_members");
$conn->query("TRUNCATE com_pages");
$conn->query("TRUNCATE com_temples");
$conn->query("TRUNCATE com_maharaj_mataji");
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

echo "--- Starting Import ---\n";

// 1. Static Pages
if (file_exists("$dir/static_pages.json")) {
    echo "Importing Pages...";
    $data = json_decode(file_get_contents("$dir/static_pages.json"), true);
    $stmt = $conn->prepare("INSERT INTO com_pages (title, slug, content, status) VALUES (?, ?, ?, 1)");
    
    $fallbacks = [
        'about' => "<h2>About Rajasthan Jain Sabha</h2><p>Rajasthan Jain Sabha Jaipur, as a central representative institution of the entire Jain community, has been engaged in various social, cultural, and religious activities since its inception in 1953.</p><p>Our mission is to foster unity among Jains and promote the principles of Lord Mahavira.</p>",
        'privacy_policy' => "<h2>Privacy Policy</h2><p>We are committed to protecting your personal information and your right to privacy. This policy describes how we collect and use your data.</p>",
        'terms' => "<h2>Terms & Conditions</h2><p>By using our services, you agree to comply with our community guidelines and terms of service.</p>",
        'health_medical' => "<h2>Health & Medical Assistance</h2><p>Rajasthan Jain Sabha provides medical aid and health support to community members in need. Please contact us for further details.</p>",
        'education_scholarship' => "<h2>Education & Scholarships</h2><p>Supporting the bright future of our youth through educational funds and merit-based scholarships.</p>"
    ];

    foreach ($data as $slug => $p) {
        $content = $p['content_html'];
        if (trim($content) == "" && isset($fallbacks[$slug])) {
            $content = $fallbacks[$slug];
        }
        $stmt->bind_param("sss", $p['title'], $slug, $content);
        $stmt->execute();
    }
    echo " Done.\n";
}

// 2. Executive Members (Import these first)
if (file_exists("$dir/executive_members.json")) {
    echo "Importing Executives...";
    $data = json_decode(file_get_contents("$dir/executive_members.json"), true);
    $stmt = $conn->prepare("INSERT INTO com_members (first_name, last_name, phone, address, designation, membership_type, profile_pic, password, status) VALUES (?, '', ?, ?, ?, 'executive', ?, '123456', 1)");
    
    $exec_names = []; // Track to avoid duplicates in lifetime list
    foreach ($data as $m) {
        $img = get_hashed_name($m['photo_url']);
        $stmt->bind_param("sssss", $m['name'], $m['mobile'], $m['address'], $m['designation'], $img);
        $stmt->execute();
        // Track imported names to avoid duplicates from the main list
        $imported_names[] = strtolower(trim($m['name']));
    }
    echo " Done.\n";
}

// 3. Temples
if (file_exists("$dir/temples.json")) {
    echo "Importing Temples...";
    $data = json_decode(file_get_contents("$dir/temples.json"), true);
    $stmt = $conn->prepare("INSERT INTO com_temples (name, address, city, phone, image_path, status) VALUES (?, ?, ?, ?, ?, 1)");
    foreach ($data as $t) {
        $img = get_hashed_name($t['image_url']);
        $stmt->bind_param("sssss", $t['name'], $t['address'], $t['city'], $t['contact'], $img);
        $stmt->execute();
    }
    echo " Done.\n";
}

// 4. Maharaj/Mataji
if (file_exists("$dir/maharaj_mataji.json")) {
    echo "Importing Maharaj/Mataji...";
    $data = json_decode(file_get_contents("$dir/maharaj_mataji.json"), true);
    $stmt = $conn->prepare("INSERT INTO com_maharaj_mataji (name, description, image_path, status) VALUES (?, ?, ?, 1)");
    foreach ($data as $m) {
        $img = get_hashed_name($m['image_url']);
        $stmt->bind_param("sss", $m['name'], $m['details'], $img);
        $stmt->execute();
    }
    echo " Done.\n";
}

// 5. Lifetime Members (Skip if already Imported as Executive)
if (file_exists("$dir/members.json")) {
    echo "Importing 34k+ Members...";
    $data = json_decode(file_get_contents("$dir/members.json"), true);
    $conn->begin_transaction();
    $stmt = $conn->prepare("INSERT IGNORE INTO com_members (first_name, last_name, membership_no, phone, profile_pic, membership_type, password, status) VALUES (?, '', ?, ?, ?, 'lifetime', '123456', 1)");
    
    $count = 0;
    foreach ($data as $m) {
        // Skip if this person is already in the Executive list (simple name check)
        if (in_array(strtolower(trim($m['name'])), $imported_names)) {
            continue; 
        }
        
        $img = get_hashed_name($m['photo_url']);
        $stmt->bind_param("ssss", $m['name'], $m['life_member_id'], $m['mobile'], $img);
        $stmt->execute();
        $count++;
        if ($count % 5000 == 0) echo ".";
    }
    $conn->commit();
    echo " Done ($count imported).\n";
}

// 6. Yellow Pages (Business Directory)
if (file_exists("$dir/yellow_pages.json")) {
    echo "Importing Yellow Pages...";
    $data = json_decode(file_get_contents("$dir/yellow_pages.json"), true);
    
    // Preparation for Categories
    $cat_map = [];
    $res = $conn->query("SELECT id, name FROM com_business_categories");
    while($row = $res->fetch_assoc()) $cat_map[strtolower($row['name'])] = $row['id'];
    
    $stmt_cat = $conn->prepare("INSERT INTO com_business_categories (name) VALUES (?)");
    $stmt_biz = $conn->prepare("INSERT INTO com_business_listings (business_name, category_id, address, contact_person, contact_phone, logo, status) VALUES (?, ?, ?, ?, ?, ?, 'approved')");
    
    foreach ($data as $b) {
        $cat_name = $b['category'];
        if(!$cat_name) $cat_name = "General";
        
        // Ensure category exists
        if(!isset($cat_map[strtolower($cat_name)])) {
            $stmt_cat->bind_param("s", $cat_name);
            $stmt_cat->execute();
            $cat_map[strtolower($cat_name)] = $conn->insert_id;
        }
        $cat_id = $cat_map[strtolower($cat_name)];
        
        $img = get_hashed_name($b['image_url']);
        
        // Single name + unique check (simplified)
        $stmt_biz->bind_param("sissss", $b['business_name'], $cat_id, $b['address'], $b['contact_person'], $b['phone'], $img);
        $stmt_biz->execute();
    }
    echo " Done.\n";
}

echo "--- Import Complete ---\n";
$conn->close();
?>
