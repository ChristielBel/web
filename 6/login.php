<?php

include '/home/u67287/www/6/stock/Client_stock.php';
include '/home/u67287/www/6/stock/conn.php';

header('Content-Type: text/html; charset=UTF-8');

$session_started = false;
if (session_start()) {
    $session_started = true;
    if (!empty($_SESSION['login']) && $_COOKIE[session_name()]) {
        header('Location: ./');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include("login_page.php");
} // Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
    $clientId = getClientIdIfAuthenticated($db, $_POST['login'], $_POST['password']);
    if ($clientId != -1) {
        if (!$session_started) {
            session_start();
        }

        setcookie('error', '', 100000);
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['id'] = $clientId;

        header('Location: ./');
    } else {
        setcookie('error', '1', time() + 24 * 60 * 60);
        header('Location: ./login.php');
    }
}