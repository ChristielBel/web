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
        header {
            background: #383858;
        }

        img{
            width:200px;
            height:200px
        }
        @media screen and (max-width: 576px) {
            .btn-group {
                flex-wrap: wrap;
            }
            .btn-group .btn {
                width: 100%;
                margin-bottom: 5px; /* Пространство между кнопками */
            }
        }
    </style>
</head>
<body>

<header class="container-fluid">
    <div class="row">
        <div class="col-4">
            <img class="logo img-fluid float-left" src="лого.png" alt="лого">
        </div>
        <div class="col-7 align-self-center text-right text-md-left pr-4">
            <h1 class="mt-5 col-12">Travel Database Interface</h1>
        </div>
    </div>
</header>


<div class="container justify-content-center">
    <div class="row justify-content-center mt-3">
        <div class="col-12 justify-content-center">
            <div class="btn-group btn-group-lg w-100">
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="1">
                    <button type="submit" class="btn btn-dark mr-2">Форма 1</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="2">
                    <button type="submit" class="btn btn-dark mr-2">Форма 2</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="3">
                    <button type="submit" class="btn btn-dark mr-2">Форма 3</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="4">
                    <button type="submit" class="btn btn-dark mr-2">Форма 4</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="5">
                    <button type="submit" class="btn btn-dark mr-2">Форма 5</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="6">
                    <button type="submit" class="btn btn-dark mr-2">Форма 6</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="7">
                    <button type="submit" class="btn btn-dark mr-2">Форма 7</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="8">
                    <button type="submit" class="btn btn-dark mr-2">Форма 8</button>
                </form>
                <form method="post" action="">
                    <input type="hidden" name="form_number" value="9">
                    <button type="submit" class="btn btn-dark mr-2">Форма 9</button>
                </form>
                <!-- Добавьте другие кнопки по мере необходимости -->
            </div>
        </div>

        <!-- Формы запросов -->
        <div class="mt-5 col-12">
            <div class="forms">
                <form id="form1" class="form form1" method="post" action=""
                      style="display: <?php echo ($currentForm == 1) ? 'block' : 'none'; ?>;">
                    <h2>Форма 1: Выборка маршрутов по стране</h2>
                    <input type="text" id="country" placeholder="Введите страну" name="country"
                           class="form-control mb-2">
                    <button type="submit" class="btn btn-dark">Найти</button>
                </form>
                <form id="form2" class="form form2" method="post" action=""
                      style="display: <?php echo ($currentForm == 2) ? 'block' : 'none'; ?>;">
                    <h2>Форма 2: Маршруты, где целью поездки является отдых и стоимость 1 дня пребывания не превышает 1000</h2>
                    <button type="submit" class="btn btn-dark">Найти</button>
                </form>
                <form id="form3" class="form form3" method="post" action=""
                      style="display: <?php echo ($currentForm == 3) ? 'block' : 'none'; ?>;">
                    <h2>Форма 3: Клиенты, совершившие поездки в течение 2004 года</h2>
                    <button type="submit" class="btn btn-dark">Найти</button>
                </form>
                <form id="form4" class="form form4" method="post" action=""
                      style="display: <?php echo ($currentForm == 4) ? 'block' : 'none'; ?>;">
                    <h2>Форма 4: Выборка маршрутов по целе поездки</h2>
                    <input type="text" id="target" placeholder="Введите цель поездки" name="target"
                           class="form-control mb-2">
                    <button type="submit" class="btn btn-dark">Найти</button>
                </form>
                <form id="form5" class="form form5" method="post" action=""
                      style="display: <?php echo ($currentForm == 5) ? 'block' : 'none'; ?>;">
                    <h2>Форма 5: Выборка маршрутов по целе поездки</h2>
                    <input type="text" id="min" placeholder="Введите минимальное количество дней пребывания" name="min"
                           class="form-control mb-2">
                    <input type="text" id="max" placeholder="Введите максимальное количество дней пребывания" name="max"
                           class="form-control mb-2">
                    <button type="submit" class="btn btn-dark">Найти</button>
                </form>
                <form id="form6" class="form form6" method="post" action=""
                      style="display: <?php echo ($currentForm == 6) ? 'block' : 'none'; ?>;">
                    <h2>Форма 6: Клиенты, совершившие поездки в течение 2004 года</h2>
                    <button type="submit" class="btn btn-dark">Найти</button>
                </form>
                <form id="form7" class="form form7" method="post" action=""
                      style="display: <?php echo ($currentForm == 7) ? 'block' : 'none'; ?>;">
                    <h2>Форма 7: Клиенты, совершившие поездки в течение 2004 года</h2>
                    <button type="submit" class="btn btn-dark">Найти</button>
                </form>
                <form id="form8" class="form form8" method="post" action=""
                      style="display: <?php echo ($currentForm == 8) ? 'block' : 'none'; ?>;">
                    <h2>Форма 8: Клиенты, совершившие поездки в течение 2004 года</h2>
                    <button type="submit" class="btn btn-dark">Найти</button>
                </form>
                <form id="form9" class="form form9" method="post" action=""
                      style="display: <?php echo ($currentForm == 9) ? 'block' : 'none'; ?>;">
                    <h2>Форма 9: Маршруты, где целью поездки является лечение</h2>
                    <button type="submit" class="btn btn-dark">Найти</button>
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
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
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
                <?php if (isset($data2)): ?>
                    <?php if (!empty($data2)): ?>
                        <h2>Результаты запроса</h2>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Цена за день</th>
                                <th>Цена визы</th>
                                <th>Цена транспорта</th>
                                <th>Страна назначения</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data2 as $row): ?>
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
                <?php if (isset($data3)): ?>
                    <?php if (!empty($data3)): ?>
                        <h2>Результаты запроса</h2>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>ФИО</th>
                                <th>Пол</th>
                                <th>Дата рождения</th>
                                <th>Место рождения</th>
                                <th>Цель поездки</th>
                                <th>Дата начала поездки</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data3 as $row): ?>
                                <tr>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td><?php echo $row["gender"]; ?></td>
                                    <td><?php echo $row["birthday"]; ?></td>
                                    <td><?php echo $row["birthplace"]; ?></td>
                                    <td><?php echo $row["target"]; ?></td>
                                    <td><?php echo $row["start_date"]; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <h2>Результаты запроса</h2>
                        <p>Нет данных о маршрутах для выбранной страны.</p>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (isset($data4)): ?>
                    <?php if (!empty($data4)): ?>
                        <h2>Результаты запроса</h2>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Цена за день</th>
                                <th>Цена визы</th>
                                <th>Цена транспорта</th>
                                <th>Страна назначения</th>
                                <th>Цель поездки</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data4 as $row): ?>
                                <tr>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["price_per_day"]; ?></td>
                                    <td><?php echo $row["visa_price"]; ?></td>
                                    <td><?php echo $row["transport_price"]; ?></td>
                                    <td><?php echo $row["destination_country"]; ?></td>
                                    <td><?php echo $row["target"]; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <h2>Результаты запроса</h2>
                        <p>Нет данных о маршрутах для выбранной страны.</p>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (isset($data5)): ?>
                    <?php if (!empty($data5)): ?>
                        <h2>Результаты запроса</h2>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>ID клиента</th>
                                <th>ФИО</th>
                                <th>Страна назначения</th>
                                <th>Цель поездки</th>
                                <th>Дата начала поездки</th>
                                <th>Количество дней пребывания</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data5 as $row): ?>
                                <tr>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td><?php echo $row["destination_country"]; ?></td>
                                    <td><?php echo $row["target"]; ?></td>
                                    <td><?php echo $row["start_date"]; ?></td>
                                    <td><?php echo $row["duration"]; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <h2>Результаты запроса</h2>
                        <p>Нет данных о маршрутах для выбранной страны.</p>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (isset($data6)): ?>
                    <?php if (!empty($data6)): ?>
                        <h2>Результаты запроса</h2>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>Страна назначения</th>
                                <th>Цель поездки</th>
                                <th>Дата начала поездки</th>
                                <th>Количество дней пребывания</th>
                                <th>Стоимость без НДС</th>
                                <th>Стоимость с НДС</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data6 as $row): ?>
                                <tr>
                                    <td><?php echo $row["destination_country"]; ?></td>
                                    <td><?php echo $row["target"]; ?></td>
                                    <td><?php echo $row["start_date"]; ?></td>
                                    <td><?php echo $row["duration"]; ?></td>
                                    <td><?php echo $row["cost_excluding_vat"]; ?></td>
                                    <td><?php echo $row["cost_including_vat"]; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <h2>Результаты запроса</h2>
                        <p>Нет данных о маршрутах для выбранной страны.</p>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (isset($data7)): ?>
                    <?php if (!empty($data7)): ?>
                        <h2>Результаты запроса</h2>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>Страна назначения</th>
                                <th>Средняя стоимость 1 дня пребывания</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data7 as $row): ?>
                                <tr>
                                    <td><?php echo $row["destination_country"]; ?></td>
                                    <td><?php echo $row["avg_price_per_day"]; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <h2>Результаты запроса</h2>
                        <p>Нет данных о маршрутах для выбранной страны.</p>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (isset($data8)): ?>
                    <?php if (!empty($data8)): ?>
                        <h2>Результаты запроса</h2>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>Страна назначения</th>
                                <th>Минимальная стоимость транспортных услуг</th>
                                <th>Максимальная стоимость транспортных услуг</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data8 as $row): ?>
                                <tr>
                                    <td><?php echo $row["destination_country"]; ?></td>
                                    <td><?php echo $row["min_transport_price"]; ?></td>
                                    <td><?php echo $row["max_transport_price"]; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <h2>Результаты запроса</h2>
                        <p>Нет данных о маршрутах для выбранной страны.</p>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (isset($data9)): ?>
                    <?php if (!empty($data9)): ?>
                        <h2>Результаты запроса</h2>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Цена за день</th>
                                <th>Цена визы</th>
                                <th>Цена транспорта</th>
                                <th>Страна назначения</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data9 as $row): ?>
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