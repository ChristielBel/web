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
    print('<div id="messages">');
    // Выводим все сообщения.
    foreach ($messages as $message) {
        print($message);
    }
    print('</div>');
}
// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>
<div class="container mt-5">
    <h1 class="text-center">Form</h1>
    <form id="form" action="" method="POST">

        <div class="form-group">
            <label for="fullname">ФИО:</label>
            <input type="text" class="form-control <?php
            if ($errors['fullname']) {
                print 'error';
            }
            ?>" value="<?php
            print $values['fullname']
            ?>" placeholder="Введите ваше ФИО"
                   id="fullname" name="fullname">
        </div>

        <div class="form-group">
            <label for="telephone">Телефон:</label>
            <input type="tel" class="form-control <?php
            if ($errors['telephone']) {
                print 'error';
            }
            ?>" value="<?php
            print $values['telephone'];
            ?>" placeholder="Введите ваш номер телефона"
                   id="telephone" name="telephone">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input
                    type="email" class="form-control
                    <?php
            if ($errors['email']) {
                print 'error';
            }
            ?>" value="<?php
            print $values['email'];
            ?>" placeholder="Введите вашу почту"
                    id="email" name="email">
        </div>

        <div class="form-group">
            <label for="birthday">Дата рождения:</label><br>
            <input id="birthday" name="birthday"
                   type="date" class="form-control <?php
            if ($errors['birthday']) {
                print 'error';
            }
            ?>" value="<?php
            print $values['birthday'];
            ?>">
        </div>

        <div class="form-group">
            <label>Пол:</label>
            <div class="check wrapper <?php
            if ($errors['gender']) {
                print 'error';
            }
            ?>">
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="Male" name="gender" value="Male" <?php
                    if ($values['gender'] == 'Male') {
                        print 'checked';
                    }
                    ?>>
                    <label class="form-check-label" for="Male">Мужской</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="Female" name="gender" value="Female" <?php
                    if ($values['gender'] == 'Female') {
                        print 'checked';
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
                print 'error';
            }
            ?>" id="language" name="language[]">
                <?php
                $selected = $values['language'];
                if (!empty($selected)) {
                    foreach ($validOptions as $option) {
                        if (in_array($option, $selected)) {
                            print "<option selected>$option</option>";
                        } else {
                            print "<option>$option</option>";
                        }
                    }
                } else {
                    foreach ($validOptions as $option) {
                        print "<option>$option</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="biography">Биография:</label>
            <textarea class="form-control <?php
            if ($errors['biography']) {
                print 'error';
            }
            ?>" placeholder="Введите ваше сообщение"
                      id="biography" name="biography" rows="4"><?php
                print $values['biography']
                ?></textarea>
        </div>

        <div class="form-check <?php
        if ($errors['checkk']) {
            print 'error';
        }
        ?>">
            <input type="checkbox" class="form-check-input" id="checkk" name="checkk" <?php
            if (!empty($values['checkk'])) {
                print 'checked';
            }
            ?>>
            <label class="form-check-label" for="checkk">С контрактом ознакомлен(а)</label>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Сохранить</button>
    </form>
</div>

</body>
</html>