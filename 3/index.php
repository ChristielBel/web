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
$errors = array();

// Проверка поля ФИО
if (empty($_POST['name']) || strlen($_POST['name']) > 150 || !preg_match('/^[a-zA-Zа-яА-Я\s]+$/', $_POST['name'])) {
    $errors[] = 'Поле ФИО должно содержать только буквы и пробелы и быть не длиннее 150 символов.';
}

// Проверка поля Телефон
if (empty($_POST['telephone']) || !preg_match('/^\+?[0-9()\s-]+$/', $_POST['telephone'])) {
    $errors[] = 'Введите корректный номер телефона.';
}

// Проверка поля Email
if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Введите корректный email адрес.';
}

// Проверка поля Дата рождения
if (empty($_POST['birthday'])) {
    $errors[] = 'Введите вашу дату рождения.';
}

// Проверка поля Пол
$validGenders = array('Male', 'Female'); // допустимые значения для поля Пол
if (empty($_POST['gender']) || !in_array($_POST['gender'], $validGenders)) {
    $errors[] = 'Выберите ваш пол из предопределенных вариантов.';
}

// Проверка поля Любимый язык программирования
if (empty($_POST['language']) || count($_POST['language']) < 1) {
    $errors[] = 'Выберите хотя бы один язык программирования.';
}

if (isset($_POST['language'])) {
    $invalidOptions = array_diff($_POST['language'], $validOptions);
    if (!empty($invalidOptions)) {
        print('Неверно выбраны языки программирования.<br/>');
        $errors = TRUE;
    }
}

// Проверка поля Биография
if (empty($_POST['biography']) || strlen($_POST['biography']) < 10) {
    $errors[] = 'Введите вашу биографию (не менее 10 символов).';
}

// Проверка чекбокса ознакомления с контрактом
if (!isset($_POST['check'])) {
    $errors[] = 'Для продолжения необходимо ознакомиться с контрактом.';
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . '<br>';
    }
    exit();
}

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
    $linkQuery = 'insert into clients_languages (clients_id, languages_id) values (?, ?)';
    $languageStatement = $db->prepare($languageQuery);
    $linkStatement = $db->prepare($linkQuery);
    foreach ($_POST['language'] as $language) {
        $languageStatement->execute([$language]);
        $languageId = $languageStatement->fetchColumn();
        $linkStatement->execute([$userId, $languageId]);
    }

} catch (PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
}

header('Location: ?save=1');