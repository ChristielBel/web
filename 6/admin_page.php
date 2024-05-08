<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-row {
            display: flex;
            align-items: center;
        }
        .form-row .btn {
            margin-left: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <?php foreach ($clients as $client): ?>
                <h5> Введенные данные пользователя <?= $client['fullname'] ?> (id <?= $client['id'] ?>)</h5>
                <form method="post" action="">
                    <input type="hidden" name="id" value="<?= $client['id'] ?>">

                    <div class="form-group mt-2">
                        <label for="fullname">ФИО:</label>
                        <input type="text" class="form-control" name="fullname" placeholder="Введите ФИО" value="<?= $client['fullname'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" class="form-control" name="email" placeholder="Введите email" value="<?= $client['email'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="telephone">Телефон:</label>
                        <input type="text" class="form-control" name="telephone" placeholder="Введите телефон" value="<?= $client['telephone'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="birthday">Дата рождения:</label>
                        <input type="date" class="form-control" name="birthday" value="<?= $client['birthday'] ?>">
                    </div>

                    <div class="form-group">
                        <label>Пол:</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="Male" value="Male" <?= ($client['gender'] === 'Male' ? 'checked' : '') ?>>
                            <label class="form-check-label" for="Male">Мужской</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="Female" value="Female" <?= ($client['gender'] === 'Female' ? 'checked' : '') ?>>
                            <label class="form-check-label" for="Female">Женский</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="biography">Биография:</label>
                        <textarea class="form-control" name="biography" rows="3"><?= $client['biography'] ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="language">Любимый язык программирования:</label><br>
                        <select multiple class="form-control" name="language[]">
                            <?php foreach ($validLanguages as $language): ?>
                                <option value="<?= $language ?>" <?= (in_array($language, $languages[$client['client_id']]) ? 'selected' : '') ?>><?= $language ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="id" value="<?= $client['id'] ?>">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </form>
                <hr>
            <?php endforeach; ?>
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
                <?php foreach ($statistics as $language => $count): ?>
                    <tr>
                        <td><?= $language ?></td>
                        <td><?= $count ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>