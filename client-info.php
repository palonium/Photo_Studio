<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'administrator') {
    // Если роль не "administrator", перенаправляем на соответствующую страницу
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/style.css">
    <title>Админ-панель</title>

    <!-- Добавляем CSS стили -->
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
<header class="header">
        <div class="container header__container">
        <a href="#">
                <svg width="239" height="70" viewBox="0 0 239 70" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g clip-path="url(#clip0_1_2)">
                    <rect width="239" height="70" fill="white"/>
                    <rect width="70" height="70" fill="url(#pattern0)"/>
                    <path d="M75.28 55V27H79.6V50.84H94.96V55H75.28ZM111.83 55.4C110.203 55.4 108.777 55.0267 107.55 54.28C106.323 53.5067 105.363 52.4267 104.67 51.04C104.003 49.6267 103.67 47.9467 103.67 46V34H107.79V44.72C107.79 46.1867 108.003 47.44 108.43 48.48C108.857 49.4933 109.497 50.2667 110.35 50.8C111.203 51.3333 112.257 51.6 113.51 51.6C114.417 51.6 115.257 51.4533 116.03 51.16C116.803 50.8667 117.47 50.4533 118.03 49.92C118.617 49.3867 119.07 48.7467 119.39 48C119.737 47.2533 119.91 46.4267 119.91 45.52V34H124.03V55H119.91V50.6L120.63 50.12C120.31 51.0267 119.737 51.8933 118.91 52.72C118.083 53.52 117.07 54.1733 115.87 54.68C114.67 55.16 113.323 55.4 111.83 55.4ZM133.825 55V34H137.985V39.12L136.905 39.28C137.119 38.64 137.492 37.9867 138.025 37.32C138.559 36.6533 139.225 36.0533 140.025 35.52C140.825 34.96 141.705 34.5067 142.665 34.16C143.652 33.8133 144.705 33.64 145.825 33.64C147.132 33.64 148.305 33.8533 149.345 34.28C150.385 34.7067 151.225 35.36 151.865 36.24C152.532 37.12 152.972 38.2133 153.185 39.52L152.225 39.28L152.505 38.6C152.825 38.04 153.265 37.48 153.825 36.92C154.412 36.3333 155.092 35.8 155.865 35.32C156.665 34.8133 157.519 34.4133 158.425 34.12C159.332 33.8 160.265 33.64 161.225 33.64C163.092 33.64 164.599 34 165.745 34.72C166.892 35.44 167.732 36.4667 168.265 37.8C168.799 39.1333 169.065 40.72 169.065 42.56V55H164.905V42.96C164.905 41.76 164.732 40.76 164.385 39.96C164.065 39.1333 163.559 38.5067 162.865 38.08C162.172 37.6533 161.265 37.44 160.145 37.44C159.212 37.44 158.332 37.6 157.505 37.92C156.705 38.2133 155.999 38.64 155.385 39.2C154.772 39.7333 154.292 40.36 153.945 41.08C153.625 41.8 153.465 42.5733 153.465 43.4V55H149.305V42.88C149.305 41.76 149.119 40.8 148.745 40C148.372 39.1733 147.812 38.5467 147.065 38.12C146.319 37.6667 145.372 37.44 144.225 37.44C143.319 37.44 142.492 37.6 141.745 37.92C140.999 38.24 140.332 38.6667 139.745 39.2C139.185 39.7333 138.745 40.3333 138.425 41C138.132 41.64 137.985 42.3067 137.985 43V55H133.825ZM188.907 55.4C186.587 55.4 184.521 54.9333 182.707 54C180.921 53.04 179.507 51.7467 178.467 50.12C177.427 48.4667 176.907 46.5867 176.907 44.48C176.907 42.3733 177.427 40.5067 178.467 38.88C179.507 37.2267 180.921 35.9333 182.707 35C184.521 34.04 186.587 33.56 188.907 33.56C191.201 33.56 193.241 34.04 195.027 35C196.841 35.9333 198.267 37.2267 199.307 38.88C200.347 40.5067 200.867 42.3733 200.867 44.48C200.867 46.5867 200.347 48.4667 199.307 50.12C198.267 51.7467 196.841 53.04 195.027 54C193.241 54.9333 191.201 55.4 188.907 55.4ZM188.907 51.64C190.374 51.64 191.694 51.3333 192.867 50.72C194.067 50.08 195.001 49.2267 195.667 48.16C196.361 47.0667 196.694 45.84 196.667 44.48C196.694 43.0933 196.361 41.8667 195.667 40.8C195.001 39.7067 194.067 38.8533 192.867 38.24C191.694 37.6267 190.374 37.32 188.907 37.32C187.441 37.32 186.107 37.64 184.907 38.28C183.707 38.8933 182.761 39.7333 182.067 40.8C181.401 41.8667 181.081 43.0933 181.107 44.48C181.081 45.84 181.401 47.0667 182.067 48.16C182.761 49.2267 183.707 50.08 184.907 50.72C186.107 51.3333 187.441 51.64 188.907 51.64ZM216.506 55.4C214.48 55.4 212.626 55.0933 210.946 54.48C209.293 53.8667 207.906 52.9067 206.786 51.6L209.586 49.12C210.493 50.08 211.52 50.8 212.666 51.28C213.84 51.76 215.133 52 216.546 52C217.106 52 217.666 51.9467 218.226 51.84C218.786 51.7333 219.293 51.5733 219.746 51.36C220.2 51.1467 220.56 50.8667 220.826 50.52C221.093 50.1733 221.226 49.7733 221.226 49.32C221.226 48.5467 220.773 47.9467 219.866 47.52C219.386 47.3333 218.8 47.1333 218.106 46.92C217.413 46.7067 216.6 46.5067 215.666 46.32C214.093 45.9733 212.733 45.5867 211.586 45.16C210.44 44.7067 209.52 44.16 208.826 43.52C208.32 43.0133 207.933 42.44 207.666 41.8C207.426 41.16 207.306 40.4267 207.306 39.6C207.306 38.72 207.52 37.9067 207.946 37.16C208.4 36.4133 209.026 35.7733 209.826 35.24C210.626 34.7067 211.56 34.2933 212.626 34C213.693 33.7067 214.84 33.56 216.066 33.56C217.16 33.56 218.266 33.6933 219.386 33.96C220.533 34.2 221.6 34.5733 222.586 35.08C223.6 35.56 224.44 36.1733 225.106 36.92L222.826 39.6C222.213 39.0933 221.52 38.64 220.746 38.24C220 37.84 219.226 37.5333 218.426 37.32C217.626 37.08 216.88 36.96 216.186 36.96C215.6 36.96 215.013 37.0133 214.426 37.12C213.84 37.2 213.32 37.3467 212.866 37.56C212.44 37.7467 212.093 38 211.826 38.32C211.56 38.64 211.426 39.0267 211.426 39.48C211.426 39.8267 211.506 40.1467 211.666 40.44C211.853 40.7067 212.093 40.9467 212.386 41.16C212.84 41.4533 213.453 41.72 214.226 41.96C215 42.2 215.92 42.4267 216.986 42.64C218.373 42.9333 219.6 43.28 220.666 43.68C221.76 44.0533 222.666 44.52 223.386 45.08C224 45.5333 224.453 46.08 224.746 46.72C225.066 47.36 225.226 48.0933 225.226 48.92C225.226 50.2267 224.826 51.3733 224.026 52.36C223.253 53.32 222.213 54.0667 220.906 54.6C219.6 55.1333 218.133 55.4 216.506 55.4Z" fill="#0E0E0E"/>
                    </g>
                    <defs>
                    <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                    <use xlink:href="#image0_1_2" transform="scale(0.01)"/>
                    </pattern>
                    <clipPath id="clip0_1_2">
                    <rect width="239" height="70" fill="white"/>
                    </clipPath>
                    <image id="image0_1_2" width="100" height="100" xlink:href="data:image/png;base64,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"/>
                    </defs>
                    </svg>                                
            </a>
            <nav class="header__menu">
                <ul class="menu">
                <li class="menu__item"> <a href="#" class= "menu__link back-btn" onclick="history.go(-1);">Назад</a></li>
            </ul></nav>

        </div>
    </header>
<div class="container">

<?php
// Подключение к базе данных
include 'config.php';

// Запрос для получения данных о клиентах, их контактной информации и связанных пользователях
$sql = "SELECT Client.Client_ID, Client.First_Name, Client.Last_Name, Contact_Information.Phone_Number, Contact_Information.Email_Address, User.Login
        FROM Client
        LEFT JOIN Contact_Information ON Client.Contact_ID = Contact_Information.Contact_ID
        LEFT JOIN User ON Client.User_ID = User.User_ID";
$result = $conn->query($sql);

// Вывод данных
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Client ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone Number</th>
                <th>Email Address</th>
                <th>User Login</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["Client_ID"] . "</td>
                <td>" . $row["First_Name"] . "</td>
                <td>" . $row["Last_Name"] . "</td>
                <td>" . $row["Phone_Number"] . "</td>
                <td>" . $row["Email_Address"] . "</td>
                <td>" . $row["Login"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>
</div>

</body>
</html>
