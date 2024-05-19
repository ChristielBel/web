<?php

function findAdminByUsername($db, $username) {
    try {
        $adminStmt = $db->prepare("select * from admin where login = ?");
        $adminStmt->execute([$username]);
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Логирование ошибки на сервере
        print('An error occurred. Please try again later.');
        exit();
    }
    return $adminStmt->fetch();
}