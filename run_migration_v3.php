<?php
$hostname = "localhost";
$username = "root"; 
$password = ""; 
$database = "temple"; 

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$sqlFile = 'sql/v3_rajasthan_jain_sabha.sql';
if (!file_exists($sqlFile)) { die("SQL file not found: $sqlFile"); }

$sql = file_get_contents($sqlFile);

if ($conn->multi_query($sql)) {
    do { if ($result = $conn->store_result()) { $result->free(); } } while ($conn->more_results() && $conn->next_result());
    echo "Database migrated successfully to V3 (Rajasthan Jain Sabha Architecture).";
} else {
    echo "Error executing migration: " . $conn->error;
}
$conn->close();
?>
