<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Массив для временного хранения сообщений пользователю.
    $messages = array();
    if (!empty($_COOKIE['save'])) {
            setcookie('save', '', 100000);
            setcookie('login', '', 100000);
            setcookie('pass', '', 100000);
            $messages[] = 'Спасибо, результаты сохранены.';
            if (!empty($_COOKIE['pass'])) {
                $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
            и паролем <strong>%s</strong> для изменения данных.',
                    strip_tags($_COOKIE['login']),
                    strip_tags($_COOKIE['pass']));
            }
        }

    // Складываем признак ошибок в массив.
    $errors = array();
    $errors['name'] = !empty($_COOKIE['name_error']);
    $errors['telephone'] = !empty($_COOKIE['telephone_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['birthday'] = !empty($_COOKIE['birthday_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['language'] = !empty($_COOKIE['language_error']);
    $errors['biography'] = !empty($_COOKIE['biography_error']);
    $errors['checkk'] = !empty($_COOKIE['checkk_error']);

    // Выдаем сообщения об ошибках.
    if ($errors['name']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('name_error', '', 100000);
        setcookie('name_value', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error-message">Поле имя должно содержать только пробелы и буквы</div>';
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
        $messages[] = '<div class="error-message">Введите вашу биографию (не менее 10 символов).</div>';
    }
    if ($errors['checkk']) {
        setcookie('checkk_error', '', 100000);
        setcookie('checkk_value', '', 100000);
        $messages[] = '<div class="error-message">Для продолжения необходимо ознакомиться с контрактом.</div>';
    }

    // Складываем предыдущие значения полей в массив, если есть.
    $values = array();
    $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
    $values['telephone'] = empty($_COOKIE['telephone_value']) ? '' : $_COOKIE['telephone_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['birthday'] = empty($_COOKIE['birthday_value']) ? '' : $_COOKIE['birthday_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['language'] = empty($_COOKIE['language_value']) ? '' : json_decode($_COOKIE['language_value']);
    $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
    $values['checkk'] = empty($_COOKIE['checkk_value']) ? '' : $_COOKIE['checkk_value'];
// Сохранение в базу данных.

    $user = 'u67287'; // Заменить на ваш логин uXXXXX
    $pass = '3328006'; // Заменить на пароль, такой же, как от SSH
    $db = new PDO('mysql:host=localhost;dbname=u67287', $user, $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); // Заменить test на имя БД, совпадает с логином uXXXXX

    $statement = $db->prepare("select language from languages");
    $statement->execute();
    $validOptions = [];
    foreach ($statement as $row) {
        $validOptions[] = $row['language'];
    }

     // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
        // ранее в сессию записан факт успешного логина.
        if (empty($errors) && !empty($_COOKIE[session_name()]) &&
            session_start() && !empty($_SESSION['login'])) {
            // TODO: загрузить данные пользователя из БД
            // и заполнить переменную $values,
            // предварительно санитизовав.

            $user = 'u67287';
            $pass = '3328006';
            $db = new PDO('mysql:host=localhost;dbname=u67321', $user, $pass,
                [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            try {
                $userStmt = $db->prepare("select a.* from users a join usert5 b on a.user_id = b.id where b.id = ?");
                $userStmt->execute([$_SESSION['id']]);
                $row = $userStmt->fetch();

                $values['name'] = strip_tags($_COOKIE['name_value']);
                $values['telephone'] = strip_tags($_COOKIE['telephone_value']);
                $values['email'] = strip_tags($_COOKIE['email_value']);
                $values['birthday'] = strip_tags($_COOKIE['birthday_value']);
                $values['gender'] = strip_tags($_COOKIE['gender_value']);
                $values['biography'] = strip_tags($_COOKIE['biography_value']);
                $values['checkk'] = strip_tags($_COOKIE['checkk_value']);

                $testStatement = $db->prepare("select language from languages");
                $testStatement->execute();
                $pLang = [];
                foreach ($testStatement as $row) {
                    $pLang[] = strip_tags($row['language']);
                }

                $values['language'] = $pLang;
            } catch (PDOException $e) {
                print('Error : ' . $e->getMessage());
                exit();
            }

            printf('Вход с логином %s, id %d', $_SESSION['login'], $_SESSION['id']);
        }

// Включаем содержимое файла form.php.
// В нем будут доступны переменные $messages, $errors и $values для вывода
// сообщений, полей с ранее заполненными данными и признаками ошибок.
    include('form.php');
} else {
    // Проверяем ошибки.
    $errors = FALSE;

// Проверка поля ФИО
    if (!preg_match("/^[a-zA-Z\s]{1,150}$/", $_POST['name'])) {
        // Выдаем куку на день с флажком об ошибке в поле fio.
        setcookie('name_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }

    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);

// Проверка поля Телефон
    if (empty($_POST['telephone']) || !preg_match('/^\+?[0-9()\s-]+$/', $_POST['telephone'])) {
        setcookie('telephone_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('telephone_value', $_POST['telephone'], time() + 30 * 24 * 60 * 60);


// Проверка поля Email
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);


// Проверка поля Дата рождения
    if (empty($_POST['birthday'])) {
        setcookie('birthday_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('birthday_value', $_POST['birthday'], time() + 30 * 24 * 60 * 60);


// Проверка поля Пол
    $validGenders = array('Male', 'Female'); // допустимые значения для поля Пол
    if (empty($_POST['gender']) || !in_array($_POST['gender'], $validGenders)) {
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);


// Проверка поля Биография
    if (empty($_POST['biography']) || strlen($_POST['biography']) < 10) {
        setcookie('biography_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);


// Проверка чекбокса ознакомления с контрактом
    if (!isset($_POST['checkk'])) {
        setcookie('checkk_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('checkk_value', isset($_POST['checkk']) ? $_POST['checkk'] : '', time() + 30 * 24 * 60 * 60);


    $user = 'u67287'; // Заменить на ваш логин uXXXXX
    $pass = '3328006'; // Заменить на пароль, такой же, как от SSH
    $db = new PDO('mysql:host=localhost;dbname=u67287', $user, $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); // Заменить test на имя БД, совпадает с логином uXXXXX

    $statement = $db->prepare("select language from languages");
    $statement->execute();
    $validOptions = [];
    foreach ($statement as $row) {
        $validOptions[] = $row['language'];
    }

    $lError = FALSE;
    if (isset($_POST['language'])) {
        $invalidOptions = array_diff($_POST['language'], $validOptions);
        if (!empty($invalidOptions)) {
            setcookie('language_error', '1', time() + 24 * 60 * 60);
            $lError = TRUE;
        }
    } else {
        $lError = TRUE;
    }
    if ($lError) {
        setcookie('language_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }

    setcookie('language_value', json_encode($_POST['language']), time() + 30 * 24 * 60 * 60);


    if ($errors) {
        // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
        header('Location: index.php');
        exit();
    } else {
        // Удаляем Cookies с признаками ошибок.
        setcookie('name_error', '', 100000);
        setcookie('phone_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('birthdate_error', '', 100000);
        setcookie('gender_error', '', 100000);
        setcookie('language_error', '', 100000);
        setcookie('biography_error', '', 100000);
        setcookie('checkk_error', '', 100000);
    }

    $user = 'u67287';
    $pass = '3328006';
    $db = new PDO('mysql:host=localhost;dbname=u67287', $user, $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

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
    }
    catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }

    // Сохраняем куку с признаком успешного сохранения.
    setcookie('save', '1');

    // Делаем перенаправление.
    header('Location: index.php');
}