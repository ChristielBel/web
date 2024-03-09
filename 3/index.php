<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
    if (!empty($_GET['save'])) {
        // Если есть параметр save, то выводим сообщение пользователю.
        print('Спасибо, результаты сохранены.');
    }
    // Включаем содержимое файла form.php.
    include('form.html');
    // Завершаем работу скрипта.
    exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
//$errors = FALSE;
//if (empty($_POST['field-name-1'])) {
//  print('Заполните имя.<br/>');
//  $errors = TRUE;
//}
//
//if (empty($_POST['field-date']) || !is_numeric($_POST['field-date']) || !preg_match('/^\d+$/', $_POST['field-date'])) {
//  print('Заполните год.<br/>');
//  $errors = TRUE;
//}
//
//
//// *************
//// Тут необходимо проверить правильность заполнения всех остальных полей.
//// *************
//
//if ($errors) {
//  // При наличии ошибок завершаем работу скрипта.
//  exit();
//}

// Сохранение в базу данных.

$user = 'u67287'; // Заменить на ваш логин uXXXXX
$pass = '3328006'; // Заменить на пароль, такой же, как от SSH
$db = new PDO('mysql:host=localhost;dbname=u67287', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); // Заменить test на имя БД, совпадает с логином uXXXXX

try {
    $userQuery = 'insert into clients 
(fullname, telephone, email, birthday, gender, biography) 
values (?, ?, ?, ?, ?, ?)';
    $userStatement = $db->prepare($userQuery);
    $userStatement->execute(
        [$_POST['name'],
            $_POST['telephone'],
            $_POST['email'],
            $_POST['birthday'],
            $_POST['gender'],
            $_POST['biography']
        ]);

    $userId = $db->lastInsertId();

    $languageQuery = 'select id from languages where language = ?';
    $linkQuery =  'insert into clients_languages (clients_id, languages_id) values (?, ?)';
    $languageStatement = $db->prepare($languageQuery);
    $linkStatement = $db->prepare($linkQuery);
    foreach ($_POST['language'] as $language) {
        $languageStatement->execute([$language]);
        $languageId = $languageStatement->fetchColumn();
        $linkStatement->execute([$userId, $languageId]);
    }

}
catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
}

header('Location: ?save=1');