<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Database Interface</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .results {
            margin-top: 50px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mt-5 col-12">Travel Database Interface</h1>
    <div class="row justify-content-center mt-3">
        <div class="col-12 justify-content-center">
            <div class="btn-group btn-group-lg w-100">
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="1">
                    <button type="submit" class="btn btn-primary mr-2">Форма 1</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="2">
                    <button type="submit" class="btn btn-primary mr-2">Форма 2</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="3">
                    <button type="submit" class="btn btn-primary mr-2">Форма 3</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="4">
                    <button type="submit" class="btn btn-primary mr-2">Форма 4</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="5">
                    <button type="submit" class="btn btn-primary mr-2">Форма 5</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="6">
                    <button type="submit" class="btn btn-primary mr-2">Форма 6</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="7">
                    <button type="submit" class="btn btn-primary mr-2">Форма 7</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="8">
                    <button type="submit" class="btn btn-primary mr-2">Форма 8</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="9">
                    <button type="submit" class="btn btn-primary mr-2">Форма 9</button>
                </form>
                <!-- Добавьте другие кнопки по мере необходимости -->
            </div>
        </div>

        <!-- Формы запросов -->
        <div class="mt-5 col-12">
            <div class="forms">
                <form id="form1" class="form form1" method="post" action=""
                      style="display: <?php echo ($currentForm == 1) ? 'block' : 'none'; ?>;">
                    <h2>Форма 1: Выборка по стране</h2>
                    <input type="text" id="country" placeholder="Введите страну" name="country"
                           class="form-control mb-2">
                    <button type="submit" class="btn btn-primary">Найти</button>
                </form>
                <form id="form2" class="form form2" method="post" action=""
                      style="display: <?php echo ($currentForm == 2) ? 'block' : 'none'; ?>;">
                    <h2>Форма 2: Выборка по стране</h2>
                    <!-- Добавьте элементы формы по мере необходимости -->
                </form>
            </div>
        </div>
    </div>

    <!-- Результаты запроса -->
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="results">
                <?php if (isset($data)): ?>
                    <?php if (!empty($data)): ?>
                        <h2>Результаты запроса</h2>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Цена за день</th>
                                <th>Цена визы</th>
                                <th>Цена транспорта</th>
                                <th>Страна назначения</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data as $row): ?>
                                <tr>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["price_per_day"]; ?></td>
                                    <td><?php echo $row["visa_price"]; ?></td>
                                    <td><?php echo $row["transport_price"]; ?></td>
                                    <td><?php echo $row["destination_country"]; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <h2>Результаты запроса</h2>
                        <p>Нет данных о маршрутах для выбранной страны.</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>