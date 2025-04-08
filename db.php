<?php
// Připojení k databázi
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "admin_interface";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Chyba při připojení: " . $conn->connect_error);
}
?>
