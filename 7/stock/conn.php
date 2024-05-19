<?php
include 'pass.php';

ini_set('display_errors', '0');
error_reporting(0);

ini_set('log_errors', '1');
ini_set('error_log', '7/error.log');

try {
    $db = new PDO('mysql:host=localhost;dbname=u67287', $user, $pass, [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    // Логирование ошибки и вывод пользовательского сообщения
    error_log($e->getMessage());
    die('Database connection error.');
}