<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
$session_started = false;
if ($_COOKIE[session_name()] && session_start()) {
    $session_started = true;
    if (!empty($_SESSION['login'])) {
        // Если есть логин в сессии, то пользователь уже авторизован.
        // TODO: Сделать выход (окончание сессии вызовом session_destroy()
        //при нажатии на кнопку Выход).
        // Делаем перенаправление на форму.
        header('Location: ./');
        exit();
    }
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    ?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <title>Войти</title>
    </head>
    <body>
    <div class="error">
        <?php
        if (!empty($_COOKIE['error'])) {
            print strip_tags($_COOKIE['error']);
        }
        ?>
    </div>

    <div class="container mt-5">
        <form method="post" action="">
            <div class="form-group">
                <label for="login">Username</label>
                <input type="text" class="form-control" name="login" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <button type="button" class="btn btn-secondary ml-2">Sign out</button>
        </form
    </div>
    </body>

    <?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
    // TODO: Проверть есть ли такой логин и пароль в базе данных.
        // Выдать сообщение об ошибках.

        $isAuth = FALSE;
        $userId = -1;
        $user = 'u67287';
        $pass = '3328006';
        $db = new PDO('mysql:host=localhost;dbname=u67287', $user, $pass,
            [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        try {
            $userQuery = 'select * from clientsid where login = ? and password = ?';
            $userStatement = $db->prepare($userQuery);
            $userStatement->execute();

            $userInfo = $userStatement->fetch();
            if ($_POST['login'] == $userInfo['login'] &&
                md5($_POST['password'] == $userInfo['password'])) {
                $userId = $userInfo['id'];
                $isAuth = TRUE;
            }
        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }

        if ($isAuth) {
            if (!$session_started) {
                session_start();
            }

            $_SESSION['login'] = $_POST['login'];
            $_SESSION['id'] = $userId;

            header('Location: ./');
        } else {
            $error = '<div class="error">Логин или пароль неверные</div>';
            setcookie('error', '1', time() + 24 * 60 * 60);
            include ('login.php');
        }
}