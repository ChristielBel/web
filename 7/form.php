<html lang="en">
<head>
    <title>Website</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <style>
        .error-message {
            color: red;
            font-weight: bold;
        }
        .error {
            border: 2px solid red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<a href="admin.php">Я администратор</a>
<?php
if (!empty($messages)) {
    htmlspecialchars(print('<div id="messages">'),ENT_QUOTES,'UTF-8');
    // Выводим все сообщения.
    foreach ($messages as $message) {
        htmlspecialchars(print($message),ENT_QUOTES,'UTF-8');
    }
    htmlspecialchars(print('</div>'),ENT_QUOTES,'UTF-8');
}
// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>
<div class="container mt-5">
    <h1 class="text-center">Form</h1>
    <form id="form" action="" method="POST">
        <input hidden="hidden" name="csrf" value="<?php print $_COOKIE["csrf"]?>">
        <div class="form-group">
            <label for="fullname">ФИО:</label>
            <input type="text" class="form-control <?php
            if ($errors['fullname']) {
                htmlspecialchars(print 'error',ENT_QUOTES,'UTF-8');
            }
            ?>" value="<?php
            htmlspecialchars(print $values['fullname'],ENT_QUOTES,'UTF-8')
            ?>" placeholder="Введите ваше ФИО"
                   id="fullname" name="fullname">
        </div>

        <div class="form-group">
            <label for="telephone">Телефон:</label>
            <input type="tel" class="form-control <?php
            if ($errors['telephone']) {
                htmlspecialchars(print 'error',ENT_QUOTES,'UTF-8');
            }
            ?>" value="<?php
            htmlspecialchars(print $values['telephone'],ENT_QUOTES,'UTF-8');
            ?>" placeholder="Введите ваш номер телефона"
                   id="telephone" name="telephone">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input
                    type="email" class="form-control
                    <?php
            if ($errors['email']) {
                htmlspecialchars(print 'error',ENT_QUOTES,'UTF-8');
            }
            ?>" value="<?php
            htmlspecialchars(print $values['email'],ENT_QUOTES,'UTF-8');
            ?>" placeholder="Введите вашу почту"
                    id="email" name="email">
        </div>

        <div class="form-group">
            <label for="birthday">Дата рождения:</label><br>
            <input id="birthday" name="birthday"
                   type="date" class="form-control <?php
            if ($errors['birthday']) {
                htmlspecialchars(print 'error',ENT_QUOTES,'UTF-8');
            }
            ?>" value="<?php
            htmlspecialchars(print $values['birthday'],ENT_QUOTES,'UTF-8');
            ?>">
        </div>

        <div class="form-group">
            <label>Пол:</label>
            <div class="check wrapper <?php
            if ($errors['gender']) {
                htmlspecialchars(print 'error',ENT_QUOTES,'UTF-8');
            }
            ?>">
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="Male" name="gender" value="Male" <?php
                    if ($values['gender'] == 'Male') {
                        htmlspecialchars(print 'checked',ENT_QUOTES,'UTF-8');
                    }
                    ?>>
                    <label class="form-check-label" for="Male">Мужской</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="Female" name="gender" value="Female" <?php
                    if ($values['gender'] == 'Female') {
                        htmlspecialchars(print 'checked',ENT_QUOTES,'UTF-8');
                    }
                    ?>>
                    <label class="form-check-label" for="Female">Женский</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="language">Любимый язык программирования:</label>
            <select multiple class="form-control <?php
            if ($errors['language']) {
                htmlspecialchars(print 'error',ENT_QUOTES,'UTF-8');
            }
            ?>" id="language" name="language[]">
                <?php
                $selected = $values['language'];
                if (!empty($selected)) {
                    foreach ($validOptions as $option) {
                        if (in_array($option, $selected)) {
                            htmlspecialchars(print "<option selected>$option</option>",ENT_QUOTES,'UTF-8');
                        } else {
                            htmlspecialchars(print "<option>$option</option>",ENT_QUOTES,'UTF-8');
                        }
                    }
                } else {
                    foreach ($validOptions as $option) {
                        htmlspecialchars(print "<option>$option</option>",ENT_QUOTES,'UTF-8');
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="biography">Биография:</label>
            <textarea class="form-control <?php
            if ($errors['biography']) {
                htmlspecialchars(print 'error',ENT_QUOTES,'UTF-8');
            }
            ?>" placeholder="Введите ваше сообщение"
                      id="biography" name="biography" rows="4"><?php
                htmlspecialchars(print $values['biography'],ENT_QUOTES,'UTF-8')
                ?></textarea>
        </div>

        <div class="form-check <?php
        if ($errors['checkk']) {
            htmlspecialchars(print 'error',ENT_QUOTES,'UTF-8');
        }
        ?>">
            <input type="checkbox" class="form-check-input" id="checkk" name="checkk" <?php
            if (!empty($values['checkk'])) {
               htmlspecialchars( print 'checked',ENT_QUOTES,'UTF-8');
            }
            ?>>
            <label class="form-check-label" for="checkk">С контрактом ознакомлен(а)</label>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Сохранить</button>
    </form>
</div>

</body>
</html>