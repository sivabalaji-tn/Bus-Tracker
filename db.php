<?php
// Database configuration
$host = "localhost:3306";
$username = "project_mini";
$password = "Sivabalaji@2027"; // Default is empty for XAMPP
$database = "project_mini";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Optional: success message for debug
// echo "✅ Connected successfully to project_mini DB";
?>
