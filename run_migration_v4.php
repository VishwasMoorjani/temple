<?php
// Simple SQL runner for CI3 environment (CLI or Browser)
define('BASEPATH', 'system/'); // Dummy
define('ENVIRONMENT', 'development'); // Fix for database.php dependence
require_once 'application/config/database.php';

$db = $db['default'];
$mysqli = new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql_file = 'sql/v4_frontend_expansion.sql';
if (!file_exists($sql_file)) {
    die("SQL file not found: $sql_file");
}

$sql = file_get_contents($sql_file);
$queries = explode(';', $sql);

foreach ($queries as $query) {
    $query = trim($query);
    if (!empty($query)) {
        if ($mysqli->query($query) === TRUE) {
            echo "Query executed successfully.\n";
        } else {
            echo "Error executing query: " . $mysqli->error . "\nQuery: " . substr($query, 0, 50) . "...\n";
            // Don't die, try next (might fail on 'already exists')
        }
    }
}

echo "V4 Migration completed.\n";
$mysqli->close();
?>
