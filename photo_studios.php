<?php
// Поддержка метода PUT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && strtoupper($_POST['_method']) === 'PUT') {
    $_SERVER['REQUEST_METHOD'] = 'PUT';
}

// Подключение к базе данных
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Операция чтения (отображение) данных
    $query = "SELECT ps.Photo_Studio_ID, ps.Name, ps.Description, CONCAT(psl.Street, ', ', psl.House) AS Address
              FROM Photo_Studio ps
              JOIN Photo_Studio_Location psl ON ps.Location_ID = psl.Location_ID";

    $result = $conn->query($query);

    // Формирование HTML-кода для таблицы
    $tableRows = "";
    while ($row = $result->fetch_assoc()) {
        $tableRows .= "<tr>
                        <td>{$row['Name']}</td>
                        <td>{$row['Description']}</td>
                        <td>{$row['Address']}</td>
                        <td>
                            <button onclick=\"deletePhotoStudio({$row['Photo_Studio_ID']})\">Delete</button>
                            <button onclick=\"editPhotoStudio({$row['Photo_Studio_ID']}, '{$row['Name']}', '{$row['Description']}', '{$row['Address']}')\">Edit</button>
                        </td>
                      </tr>";
    }
    

    echo $tableRows;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Операция удаления данных
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['deletePhotoStudioID'])) {
        $photoStudioID = $_POST['deletePhotoStudioID'];
        $query = "DELETE FROM Photo_Studio WHERE Photo_Studio_ID = $photoStudioID";

        if ($conn->query($query) === TRUE) {
            echo "Photo Studio deleted successfully";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    }


    // Операция добавления данных
    $studioName = $_POST['studioName'];
    $studioDescription = $_POST['studioDescription'];
    $locationID = $_POST['locationID'];

    // Загрузка фотографии на сервер
    $uploadsDirectory = 'uploads/';
    $photoPath = $uploadsDirectory . basename($_FILES['photo']['name']);

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
        // Фотография успешно загружена, выполнение запроса на добавление фотозала
        $query = "INSERT INTO Photo_Studio (Name, Description, Photo, Location_ID) VALUES ('$studioName', '$studioDescription', '$photoPath', '$locationID')";
        
        if ($conn->query($query) === TRUE) {
            echo "Photo Studio added successfully";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading photo";
    }
}

$conn->close();
?>
