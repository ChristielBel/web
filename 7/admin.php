<?php
include 'stock/conn.php';
include 'stock/Client_stock.php';
include 'stock/Lang_stock.php';
include 'stock/Admin_stock.php';

header('Content-Type: text/html; charset=UTF-8');
header("X-XSS-Protection: 1; mode=block");

if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW'])) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
} else {
    $username = $_SERVER['PHP_AUTH_USER'];
    $admin = findAdminByUsername($db, $username);

    if (empty($admin) ||
        md5($_SERVER['PHP_AUTH_PW']) != $admin['password']) {
        header('HTTP/1.1 401 Unanthorized');
        header('WWW-Authenticate: Basic realm="My site"');
        print('<h1>401 Неверный пароль или логин</h1>');
        exit();
    }
}

if (empty($_COOKIE["csrf"])) {
    $csrf_token = bin2hex(random_bytes(32));
    setcookie("csrf", htmlspecialchars($csrf_token), time() + 3600);
    header('Location: ./admin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $clients = findALlFormData($db);
    $languages = [];
    foreach ($clients as $user) {
        $languages[$user['client_id']] = findAllLanguagesByClient($db, $user['id']);
    }

    $validLanguages = findAllLanguages($db);
    $statistics = findCountByLanguage($db);

    if (isset($_COOKIE['edit'])) {
        setcookie('error', '', 100000);
        print('Данные успешно изменены.');
    } else {
        print('Вы успешно авторизовались и видите защищенные паролем данные.');
    }

    include('admin_page.php');
} else {
    if (empty($_POST["csrf"])
        || empty($_COOKIE["csrf"])
        || $_COOKIE["csrf"] != $_POST["csrf"]) {
        die("CSRF валиадция не удалась");
    }

    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_POST['id'];
        deleteLanguagesByClientId($db, $id);
        deleteClientById($db, $id);
    } else {
        $id = $_POST['id'];
        updateClientById($db, $id, $_POST['fullname'], $_POST['telephone'], $_POST['email'], $_POST['birthday'], $_POST['gender'], $_POST['biography']);
        deleteLanguagesByClientId($db, $id);
        saveLanguages($db, $_POST['language'], $id);
    }

    $csrf_token = bin2hex(random_bytes(32));
    setcookie("csrf", htmlspecialchars($csrf_token), time() + 3600);

    setcookie('edit', '1', time() + 24 * 60 * 60);
    header('Location: admin.php');
}