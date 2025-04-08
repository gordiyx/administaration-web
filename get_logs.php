<?php
header('Content-Type: application/json');

// Настройки подключения к базе данных
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "admin_interface";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// SQL-запрос на получение логов
$sql = "SELECT id, name, surname, email, phone, office, description, is_admin, last_login FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $logs = [];
    while ($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
    echo json_encode($logs);
} else {
    echo json_encode([]);
}

$conn->close();
?>
