<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администратор</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <div class="row">
        <div class="col">
            <?php
            foreach ($clients as $client) {
                echo '<h5> Введенные данные с id ' . $client['id'] . ' пользователя ' . $client['fullname'] . '</h5>';
                echo '<form class="form-inline" method="post" action="">';
                echo '<input type="hidden" name="id" value="' . $client['id'] . '">';
                echo '<div class="form-group mr-2">';
                echo '<label for="fullname"ФИО:</label>';
                echo '<input type="text" class="form-control" name="fullname" placeholder="Введите ФИО" value="' . $client['fullname'] . '">';
                echo '</div>';
                echo '<div class="form-group mr-2">';
                echo '<label for="email">E-mail:</label>';
                echo '<input type="email" class="form-control" name="email" placeholder="Введите email" value="' . $client['email'] . '">';
                echo '</div>';
                echo '<div class="form-group mr-2">';
                echo '<label for="telephone">Телефон:</label>';
                echo '<input type="text" class="form-control" name="telephone" placeholder="Введите телефон" value="' . $client['telephone'] . '">';
                echo '</div>';
                echo '<div class="form-group mr-2">';
                echo '<label for="birthday">Дата рождения:</label>';
                echo '<input type="date" class="form-control" name="birthday" value="' . $client['birthday'] . '">';
                echo '</div>';
                echo '<div class="form-group mr-2">';
                echo '<label for="gender">Пол:</label>';
                echo '<select class="form-control" name="gender">';
                echo '<option value="Male" ' . ($client['gender'] === 'male' ? 'selected' : '') . '>Male</option>';
                echo '<option value="Женский" ' . ($client['gender'] === 'female' ? 'selected' : '') . '>Female</option>';
                echo '</select>';
                echo '</div>';
                echo '<div class="form-group mr-2">';
                echo '<label for="biography">Биография:</label>';
                echo '<textarea class="form-control" name="biography" rows="3">' . $client['biography'] . '</textarea>';
                echo '</div>';
                echo '<div class="form-group mr-2">';
                echo '<label for="language">Любимый язык программирования</label><br>';
                echo '<select multiple class="form-control" name="language[]">';
                echo json_encode($languages[$client['client_id']]);
                foreach ($validLanguages as $language) {
                    echo '<option value="' . $language . '" ' . (in_array($language, $languages[$client['client_id']]) ? 'selected' : '') . '>' . $language . '</option>';
                }
                echo '</select>';
                echo '</div>';
                echo '<button type="submit" class="btn btn-primary mr-2">Сохранить</button>';
                echo '</form>';
                echo '<form class="form-inline" action="" method="post">';
                echo '<input type="hidden" name="id" value="' . $client['id'] . '">';
                echo '<input type="hidden" name="action" value="delete">';
                echo '<button type="submit" class="btn btn-danger">Удалить</button>';
                echo '</form>';
                echo '<hr>';
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h1>Статистика по любимым языкам</h1>
            <table class="table">
                <thead>
                <tr>
                    <th>Язык</th>
                    <th>Количество</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($statistics as $language => $count) {
                    echo "<tr>";
                    echo "<td>$language</td>";
                    echo "<td>$count</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>