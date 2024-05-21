<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Войти</title>
    <style>
        .error {
            border: 2px solid red;
        }
    </style>
</head>
<body>
<div class="messages">
    <?php
    if (!empty($_COOKIE['error'])) {
        htmlspecialchars(print '<div class="error">Логин или пароль неверные</div>',ENT_QUOTES,'UTF-8');
        setcookie('error', '', 100000);
    }
    ?>
</div>
<?php
if ($session_started && !empty($_SESSION['login'])) {
    htmlspecialchars(print '<form method="post" action="" style="position: fixed; right: 10px; top: 10px">
        <input hidden="hidden" name="logout" value="1">
        <button type="submit" class="btn btn-secondary ml-2">Sign out</button>
    </form>',ENT_QUOTES,'UTF-8');
}
?>
<div class="container mt-5">
    <form method="post" action="" class="">
        <div class="form-group">
            <label for="login">Username</label>
            <input type="text" class="form-control <?php
            if (!empty($_COOKIE['error']))
                htmlspecialchars(print 'error',ENT_QUOTES,'UTF-8');
            ?>" name="login" id="login" placeholder="Введите логин">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control <?php
            if (!empty($_COOKIE['error']))
                htmlspecialchars(print 'error',ENT_QUOTES,'UTF-8');
            ?>" name="password" id="password" placeholder="Пароль">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form
</div>
</body>