<?php

function createDatabaseAndTable() {
    $host = getenv('hostDB', true) ?: getenv('hostDB');
    $dbname   = getenv('nameDB', true) ?: getenv('nameDB');
    $username = getenv('userDB', true) ?: getenv('userDB');
    $password = getenv('passDB', true) ?: getenv('passDB');
    try {
        // Подключение
        $dsn = "mysql:host=$host";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Создание БД
        $sqlCreateDatabase = "CREATE DATABASE IF NOT EXISTS $dbname";
        $pdo->query($sqlCreateDatabase);

        // Создание таблицы 
        $pdo->query("USE $dbname");
        $sqlCreateTable = "CREATE TABLE IF NOT EXISTS `homework2` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `value_number` INT
        )";
        $pdo->query($sqlCreateTable);

        // Тест вставка первой записи (-1)
        $sqlInsertRecord = "INSERT INTO `homework2` (`value_number`) VALUES (-1)";
        $flagInsert = $pdo->exec($sqlInsertRecord);
        $pdo = null;
        
        if ($flagInsert==1){
            return 0;
        } else {
            return 1;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$result = createDatabaseAndTable();
if($result){
    echo "Error insert";
} else{
    echo "Success, great, Отлично, все должно работать.";
}
