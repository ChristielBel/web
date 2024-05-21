<?php
include 'stock/conn.php';
include 'stock/Client_stock.php';
include 'stock/Lang_stock.php';

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();

    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        setcookie('login', '', 100000);
        $messages[] = 'Спасибо, результаты сохранены.';
        if (!empty($_COOKIE['pass'])) {
            $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
                htmlspecialchars($_COOKIE['login']),
                htmlspecialchars($_COOKIE['pass']));
        }
        setcookie('pass', '', 100000);

    }

    // Складываем признак ошибок в массив.
    $errors = handleErrors($messages);

    // Складываем предыдущие значения полей в массив, если есть.
    // При этом санитизуем все данные для безопасного отображения в браузере.
    $values = restoreValues($db);
    $validOptions = findAllLanguages($db);

    // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
    // ранее в сессию записан факт успешного логина.
    if (empty($errors) && !empty($_COOKIE[session_name()]) &&
        session_start() && !empty($_SESSION['login'])) {

        $row = findUserByUserId($db, $_SESSION['id']);

        $values['fullname'] = htmlspecialchars($row['fullname_value']);
        $values['telephone'] = htmlspecialchars($row['telephone_value']);
        $values['email'] = htmlspecialchars($row['email_value']);
        $values['birthday'] = htmlspecialchars($row['birthday_value']);
        $values['gender'] = htmlspecialchars($row['gender_value']);
        $values['biography'] = htmlspecialchars($row['biography_value']);
        $values['checkk'] = htmlspecialchars($row['checkk_value']);
        $values['language'] = htmlspecialchars($db, $row['id']);

        printf('Вход с логином %s, id %d', $_SESSION['login'], $_SESSION['id']);
    }

    // Включаем содержимое файла form.php.
    // В нем будут доступны переменные $messages, $errors и $values для вывода
    // сообщений, полей с ранее заполненными данными и признаками ошибок.
    include('form.php');
} // Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
    // Проверяем ошибки.
    $errors = testForErrors($db);

    if ($errors) {
        // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
        header('Location: index.php');
        exit();
    } else {
        // Удаляем Cookies с признаками ошибок.
        setcookie('fullname_error', '', 100000);
        setcookie('telephone_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('birthday_error', '', 100000);
        setcookie('gender_error', '', 100000);
        setcookie('language_error', '', 100000);
        setcookie('biography_error', '', 100000);
        setcookie('checkk_error', '', 100000);
    }

    // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
    if (!empty($_COOKIE[session_name()]) &&
        session_start() && !empty($_SESSION['login'])) {

        updateClientByClientId($db, $_SESSION['id'], $_POST['fullname'], $_POST['telephone'], $_POST['email'], $_POST['birthday'], $_POST['gender'], $_POST['biography']);
        $formId = getFormId($db, $_SESSION['id']);
        deleteLanguagesByClientId($db, $formId);
        saveLanguages($db, $_POST['language'], $formId);
    } else {
        $id = mt_rand(1, 100000000);
        $login = 'client' . $id;
        $pass = substr(str_shuffle("!@#$%^&*()-_+=0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 12);
        // Сохраняем в Cookies.
        setcookie('login', $login, time() + 24 * 60 * 60);
        setcookie('pass', $pass, time() + 24 * 60 * 60);

        saveToClientsid($db, $id, $login, $pass);
        $clientId = saveToClients($db, $id, $_POST['fullname'], $_POST['telephone'], $_POST['email'], $_POST['birthday'], $_POST['gender'], $_POST['biography']);

        saveLanguages($db, $_POST['language'], $clientId);
    }
    setcookie('save', '1');

    header('Location: ./');
}

function handleErrors(&$messages) {
    $errors = array();
    $errors['fullname'] = !empty($_COOKIE['fullname_error']);
    $errors['telephone'] = !empty($_COOKIE['telephone_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['birthday'] = !empty($_COOKIE['birthday_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['language'] = !empty($_COOKIE['language_error']);
    $errors['biography'] = !empty($_COOKIE['biography_error']);
    $errors['checkk'] = !empty($_COOKIE['checkk_error']);

    // Выдаем сообщения об ошибках.
    if ($errors['fullname']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('fullname_error', '', 100000);
        setcookie('fullname_value', '', 100000);

        // Выводим сообщение.
        $messages[] = '<div class="error-message">Поле имя должно быть не длиннее 150 символов и содержать только пробелы и буквы</div>';
    }
    if ($errors['telephone']) {
        setcookie('telephone_error', '', 100000);
        setcookie('telephone_value', '', 100000);

        $messages[] = '<div class="error-message">Поле телефон должно быть не длиннее 12 символов и содержать только цифры и знак +</div>';
    }
    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        setcookie('email_value', '', 100000);

        $messages[] = '<div class="error-message">Неверный формат email</div>';
    }
    if ($errors['birthday']) {
        setcookie('birthday_error', '', 100000);
        setcookie('birthday_value', '', 100000);

        $messages[] = '<div class="error-message">Неверный формат даты, используйте формат yyyy-mm-dd</div>';
    }
    if ($errors['gender']) {
        setcookie('gender_error', '', 100000);
        setcookie('gender_value', '', 100000);

        $messages[] = '<div class="error-message">Выберите пол</div>';
    }
    if ($errors['language']) {
        setcookie('language_error', '', 100000);
        setcookie('language_value', '', 100000);

        $messages[] = '<div class="error-message">Выберите язык</div>';
    }
    if ($errors['biography']) {
        setcookie('biography_error', '', 100000);
        setcookie('biography_value', '', 100000);

        $messages[] = '<div class="error-message">Поле биография может содержать только буквы, цифры, символы .,!?\'\"()</div>';
    }
    if ($errors['checkk']) {
        setcookie('checkk_error', '', 100000);
        setcookie('checkk_value', '', 100000);

        $messages[] = '<div class="error-message">Необходимо ознакомиться с контрактом</div>';
    }
    return $errors;
}

function restoreValues($db) {
    $values = array();
    $values['fullname'] = empty($_COOKIE['fullname_value']) ? '' : htmlspecialchars($_COOKIE['fullname_value']);
    $values['telephone'] = empty($_COOKIE['telephone_value']) ? '' : htmlspecialchars($_COOKIE['telephone_value']);
    $values['email'] = empty($_COOKIE['email_value']) ? '' : htmlspecialchars($_COOKIE['email_value']);
    $values['birthday'] = empty($_COOKIE['birthday_value']) ? '' : htmlspecialchars($_COOKIE['birthday_value']);
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : htmlspecialchars($_COOKIE['gender_value']);
    $plValues = json_decode(empty($_COOKIE['language_value']) ? '' : $_COOKIE['language_value']);
    if (!empty($plValues)) {
        foreach ($plValues as $plValue) {
            $plValue = htmlspecialchars($plValue);
        }
    }
    $values['language'] = $plValues;
    $values['biography'] = empty($_COOKIE['biography_value']) ? '' : htmlspecialchars($_COOKIE['biography_value']);
    $values['checkk'] = empty($_COOKIE['checkk_value']) ? '' : htmlspecialchars($_COOKIE['checkk_value']);

    return $values;
}

function testForErrors($db) {
    $errors = FALSE;
    if (!preg_match("/^[a-zA-Z\s]{1,150}$/", $_POST['fullname'])) {
        // Выдаем куку на день с флажком об ошибке в поле fio.
        setcookie('fullname_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('fullname_value', $_POST['fullname'], time() + 30 * 24 * 60 * 60);

    if (!preg_match("/^\+\d{1,12}$/", $_POST['telephone'])) {
        setcookie('telephone_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('telephone_value', $_POST['telephone'], time() + 30 * 24 * 60 * 60);

    if (!preg_match("/^([a-z0-9_.-]+)@([\da-z.-]+)\.([a-z.]{2,6})$/", $_POST['email'])) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);

    if (!preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $_POST['birthday'])) {
        setcookie('birthday_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('birthday_value', $_POST['birthday'], time() + 30 * 24 * 60 * 60);

    if (empty($_POST['gender']) || $_POST['gender'] != 'Male' && $_POST['gender'] != 'Female') {
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);

    if (!preg_match("/^[a-zA-Z0-9\s.,!?'\"()]+$/", $_POST['biography'])) {
        setcookie('biography_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);

    if (!isset($_POST['checkk'])) {
        setcookie('checkk_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('checkk_value', $_POST['checkk'], time() + 30 * 24 * 60 * 60);

    $validOptions = findAllLanguages($db);

    $plError = FALSE;
    if (isset($_POST['language'])) {
        $invalidOptions = array_diff($_POST['language'], $validOptions);
        if (!empty($invalidOptions)) {
            $plError = TRUE;
        }
    } else {
        $plError = TRUE;
    }
    if ($plError) {
        setcookie('language_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('language_value', json_encode($_POST['language']), time() + 30 * 24 * 60 * 60);
    return $errors;
}