<?php
include '/home/u67287/www/pass.php';
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

$currentForm = isset($_COOKIE['current_form']) ? $_COOKIE['current_form'] : -1;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['form_number'])) {
        $formNumber = $_POST['form_number'];
        setcookie('current_form', $formNumber, time() + 24 * 60 * 60, "/"); // устанавливаем куку на 30 дней
        header('Location: ' . $_SERVER['PHP_SELF']); // Перезагружаем страницу
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include('form.php');
}
else {
    $db = new PDO('mysql:host=localhost;dbname=u67287', $user, $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);


    $country = $_POST['country']; // Получаем значение страны из формы

    // Подготавливаем SQL запрос для получения маршрутов по стране
    $stmt1 = $db->prepare('SELECT * FROM route where destination_country = ?');
    $stmt1->execute([$country]);
    $data = [];


    foreach ($stmt1 as $row) {
        $data[] = $row;
    }
    include('form.php');
}
