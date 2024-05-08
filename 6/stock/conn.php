<?php
include '/home/u67287/www/pass.php';

$db = new PDO('mysql:host=localhost;dbname=u67287', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
