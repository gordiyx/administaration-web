<?php

// Database connection configuration
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "admin_interface";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection for errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
