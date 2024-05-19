<?php

function getClientIdIfAuthenticated($db, $login, $password){
    $clientId = -1;
    try {
        $clientQuery = "select * from clientsid where login = ?";
        $clientStatement = $db->prepare($clientQuery);
        $clientStatement->execute([$login]);

        $clientInfo = $clientStatement->fetch();

        if ($clientInfo && md5($password) == $clientInfo['password']) {
            $clientId = $clientInfo['id'];
        }
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Логирование ошибки на сервере
        print('An error occurred. Please try again later.');
        exit();
    }
    return $clientId;
}

function findUserByUserId($db, $clientId){
    try {
        $clientStmt = $db->prepare("select a.* from clients a join clientsid b on a.client_id = b.id where b.id = ?");
        $clientStmt->execute([$clientId]);
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Логирование ошибки на сервере
        print('An error occurred. Please try again later.');
        exit();
    }
    return $clientStmt->fetch();
}

function updateClientByClientId($db, $clientId, $fullname, $telephone, $email, $birthday, $gender, $biography){
    try {
        $updateStmt = $db->prepare("update clients set fullname = ?, telephone = ?, email = ?, birthday = ?, gender = ?, biography = ? where client_id = ?");
        $updateStmt->execute([
            $fullname,
            $telephone,
            $email,
            $birthday,
            $gender,
            $biography,
            $clientId
        ]);
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Логирование ошибки на сервере
        print('An error occurred. Please try again later.');
        exit();
    }
}

function saveToClientsId($db, $id, $login, $password){
    try {
        $saveStmt = $db->prepare("insert into clientsid (id, login, password) values (?, ?, ?)");
        $saveStmt->execute([$id, $login, md5($password)]);
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Логирование ошибки на сервере
        print('An error occurred. Please try again later.');
        exit();
    }
}

function saveToClients($db, $clientId, $fullname, $telephone, $email, $birthday, $gender, $biography){
    try {
        $clientQuery = 'insert into clients 
(fullname, telephone, email, birthday, gender, biography, client_id) 
values (?, ?, ?, ?, ?, ?, ?)';
        $clientStatement = $db->prepare($clientQuery);
        $clientStatement->execute(
            [$fullname,
                $telephone,
                $email,
                $birthday,
                $gender,
                $biography,
                $clientId
            ]);

    } catch (PDOException $e) {
        error_log($e->getMessage()); // Логирование ошибки на сервере
        print('An error occurred. Please try again later.');
        exit();
    }
    return $db->lastInsertId();
}

function getFormId($db, $id) {
    try {
        $getFormId = $db->prepare("select id from clients where client_id = ?");
        $getFormId->execute([$id]);
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Логирование ошибки на сервере
        print('An error occurred. Please try again later.');
        exit();
    }
    return $getFormId->fetchColumn();
}

function findAllFormData($db) {
    try {
        $getFormId = $db->prepare("select * from clients");
        $getFormId->execute();
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Логирование ошибки на сервере
        print('An error occurred. Please try again later.');
        exit();
    }
    return $getFormId->fetchALl();
}

function deleteClientById($db, $id) {
    try {
        $deleteStmt = $db->prepare("delete from clients where id = ?");
        $deleteStmt->execute([$id]);
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Логирование ошибки на сервере
        print('An error occurred. Please try again later.');
        exit();
    }
}

function updateClientById($db, $id, $fullname, $telephone, $email, $birthday, $gender, $biography){
    try {
        $updateStmt = $db->prepare("update clients set fullname = ?, telephone = ?, email = ?, birthday = ?, gender = ?, biography = ? where id = ?");
        $updateStmt->execute([
            $fullname,
            $telephone,
            $email,
            $birthday,
            $gender,
            $biography,
            $id
        ]);
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Логирование ошибки на сервере
        print('An error occurred. Please try again later.');
        exit();
    }
}