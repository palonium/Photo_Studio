<?php

require "connect.php";

function tt($value){
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}

//Проверка выполнения запроса к БД
function dbCheckError($query){
    $errInfo = $query->errorInfo();
    If($errInfo[0]!== PDO::ERR_NONE){
        echo $errInfo[2];
        exit();
    }
    return true;
}

//Запрос на получение данных одной таблицы
function selectAll($table, $params = []){
    global $pdo;
    if(!empty($params)){
        echo tt($params);
    };

    $sql = "SELECT * FROM $table";

    $query =$pdo->prepare($sql);
    $query->execute();

    dbCheckError($query); 

    return $query->fetchAll();
}

$params = [
    'login' => 'polina'
];

tt(selectAll('user'));