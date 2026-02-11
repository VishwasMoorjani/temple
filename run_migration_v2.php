<?php
// Database credentials
$hostname = "localhost";
$username = "root"; 
$password = ""; 
$database = "temple"; 

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read SQL file
$sqlFile = 'sql/v2_community_install.sql';
if (!file_exists($sqlFile)) {
    die("SQL file not found: $sqlFile");
}

$sql = file_get_contents($sqlFile);

// Execute multi query
if ($conn->multi_query($sql)) {
    do {
        // Prepare next result set
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());
    echo "Database migrated successfully to V2 Architecture (Normalized & Audited).";
} else {
    echo "Error executing migration: " . $conn->error;
}

$conn->close();
?>
