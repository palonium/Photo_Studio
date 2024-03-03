<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'lumos';

$conn = new mysqli($hostname, $username, $password, $database);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}
?>

