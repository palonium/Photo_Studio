<?php
// Подключение к базе данных
include '../config.php';

// Запрос для получения списка адресов
$query = "SELECT Location_ID, CONCAT(Street, ', ', House) AS Address FROM Photo_Studio_Location";
$result = $conn->query($query);

// Формирование HTML-кода для выпадающего списка
$options = "";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='{$row['Location_ID']}'>{$row['Address']}</option>";
}

echo $options;

$conn->close();
?>
