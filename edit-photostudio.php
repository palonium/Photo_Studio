<?php
include 'config.php';

function getAllLocations($conn) {
    $locations = array();
    $sql = "SELECT Location_ID, CONCAT(Street, ', ', House) AS Location FROM Photo_Studio_Location";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $locations[] = $row;
        }
    }

    return $locations;
}

function getPhotoStudiosWithLocations($conn) {
    $photoStudios = array();
    $sql = "SELECT ps.Photo_Studio_ID, ps.Name, ps.Description, ps.Photo, CONCAT(pl.Street, ', ', pl.House) AS Location
            FROM Photo_Studio ps
            INNER JOIN Photo_Studio_Location pl ON ps.Location_ID = pl.Location_ID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $photoStudios[] = $row;
        }
    }

    return $photoStudios;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        // Если нажата кнопка "Сохранить"
        if ($_POST['action'] === 'save') {
            // Обработка данных из формы
            $name = $_POST['name'];
            $description = $_POST['description'];
            $photo = $_POST['photo'];
            $locationID = $_POST['location'];

            // Ваш код для добавления или редактирования записей в базе данных
            // Например, используйте подготовленные запросы для безопасности
            $stmt = $conn->prepare("INSERT INTO Photo_Studio (Name, Description, Photo, Location_ID) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $name, $description, $photo, $locationID);

            if ($stmt->execute()) {
                echo "Данные успешно добавлены или обновлены";
            } else {
                echo "Ошибка: " . $stmt->error;
            }

            $stmt->close();
        }

        // Если нажата кнопка "Удалить"
        elseif ($_POST['action'] === 'delete') {
            // Проверяем, есть ли параметр id в запросе
            if (isset($_POST['id'])) {
                $photoStudioID = $_POST['id'];

                // Ваш код для удаления записи
                $stmt = $conn->prepare("DELETE FROM Photo_Studio WHERE Photo_Studio_ID = ?");
                $stmt->bind_param("i", $photoStudioID);

                if ($stmt->execute()) {
                    echo "Запись успешно удалена";
                } else {
                    echo "Ошибка: " . $stmt->error;
                }

                $stmt->close();
            }
        }
    }
}

$locations = getAllLocations($conn);
$photoStudios = getPhotoStudiosWithLocations($conn);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Photo Studio</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <h1>Edit Photo Studio</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Photo</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($photoStudios as $studio): ?>
                <tr>
                    <td><?php echo $studio['Photo_Studio_ID']; ?></td>
                    <td><?php echo $studio['Name']; ?></td>
                    <td><?php echo $studio['Description']; ?></td>
                    <td><img src="<?php echo $studio['Photo']; ?>" alt="Photo"></td>
                    <td><?php echo $studio['Location']; ?></td>
                    <td>
                        <button class="editBtn" data-id="<?php echo $studio['Photo_Studio_ID']; ?>">Edit</button>
                        <button class="deleteBtn" data-id="<?php echo $studio['Photo_Studio_ID']; ?>">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form id="editForm" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="description">Description:</label>
        <input type="text" name="description" required>

        <label for="photo">Photo:</label>
        <input type="text" name="photo" required>

        <label for="location">Location:</label>
        <select name="location" required>
            <?php foreach ($locations as $location): ?>
                <option value="<?php echo $location['Location_ID']; ?>"><?php echo $location['Location']; ?></option>
            <?php endforeach; ?>
        </select>

        <input type="hidden" name="action" id="action">
        <input type="hidden" name="id" id="editId">

        <input type="submit" value="Save">
    </form>

    <script>
        $(document).ready(function() {
            $('#editForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'edit-photostudio.php',
                    type: 'post',
                    data: $('#editForm').serialize(),
                    success: function(response) {
                        alert(response);
                        location.reload(); // Перезагрузка страницы после успешного действия
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            $('.editBtn').click(function() {
                var photoStudioID = $(this).data('id');

                // Получение данных о фотостудии для редактирования
                $.ajax({
                    url: 'get-photostudio.php', // Создайте файл для обработки этого запроса
                    type: 'get',
                    data: { id: photoStudioID },
                    success: function(data) {
                        // Заполнение формы данными из полученного ответа
                        $('#editForm input[name="name"]').val(data.name);
                        $('#editForm input[name="description"]').val(data.description);
                        $('#editForm input[name="photo"]').val(data.photo);
                        $('#editForm select[name="location"]').val(data.location);
                        $('#editForm input[name="action"]').val('save');
                        $('#editForm input[name="id"]').val(photoStudioID);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            $('.deleteBtn').click(function() {
                var photoStudioID = $(this).data('id');

                if (confirm("Вы уверены, что хотите удалить запись?")) {
                    // Удаление записи
                    $.ajax({
                        url: 'edit-photostudio.php',
                        type: 'post',
                        data: { action: 'delete', id: photoStudioID },
                        success: function(response) {
                            alert(response);
                            location.reload(); // Перезагрузка страницы после успешного действия
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
