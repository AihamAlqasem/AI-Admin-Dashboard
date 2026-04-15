<?php
$dsn = "mysql:host=127.0.0.1;dbname=ai_3";
$user = "root";
$pass = "";

$options = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
);

try {
    $con = new PDO($dsn, $user, $pass, $options);
 
} catch (PDOException $ex) {
    echo "error: " . $ex->getMessage();
}
