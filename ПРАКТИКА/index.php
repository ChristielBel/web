<?php
include '/home/u67287/www/pass.php';
header('Content-Type: text/html; charset=UTF-8');

$currentForm = isset($_COOKIE['current_form']) ? $_COOKIE['current_form'] : -1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['form_number'])) {
        $formNumber = $_POST['form_number'];
        setcookie('current_form', $formNumber, time() + 24 * 60 * 60, "/");
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include('form.php');
} else {
    $db = new PDO('mysql:host=localhost;dbname=u67287', $user, $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    switch ($currentForm) {
        case 1:
            $country = $_POST['country'];

            $stmt = $db->prepare('SELECT * FROM route WHERE destination_country = ?');
            $stmt->execute([$country]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 2:
            $stmt = $db->prepare('SELECT route.*, trip.id AS trip_id FROM route JOIN trip ON route.id = trip.route_id WHERE trip.target = "Отдых" AND route.price_per_day <= 1000 ORDER BY route.id ASC');
            $stmt->execute();
            $data2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 3:
            $stmt = $db->prepare('SELECT trip.target, trip.start_date, user.* FROM user JOIN trip ON user.id = trip.user_id WHERE YEAR(trip.start_date) = 2004');
            $stmt->execute();
            $data3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 4:
            $target = $_POST['target'];

            $stmt = $db->prepare('SELECT trip.target, route.* FROM route JOIN trip ON route.id = trip.route_id WHERE target = ? ORDER BY route.id ASC');
            $stmt->execute([$target]);
            $data4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 5:
            $min = $_POST['min'];
            $max = $_POST['max'];

            $stmt = $db->prepare('SELECT user.id, user.name, route.destination_country, trip.target, trip.start_date, trip.duration
                FROM user
                JOIN trip ON user.id = trip.user_id
                JOIN route ON trip.route_id = route.id
                WHERE trip.duration BETWEEN ? AND ?');
            $stmt->execute([$min, $max]);
            $data5 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 6:
            $stmt = $db->prepare('SELECT route.destination_country, trip.target, trip.start_date, trip.duration, 
                (route.price_per_day * trip.duration + route.transport_price + route.visa_price) AS cost_excluding_vat,
                ((route.price_per_day * trip.duration + route.transport_price + route.visa_price) * 1.18) AS cost_including_vat
                FROM trip
                JOIN route ON trip.route_id = route.id
                ORDER BY cost_excluding_vat ASC');
            $stmt->execute();
            $data6 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 7:
            $stmt = $db->prepare('SELECT route.destination_country, AVG(route.price_per_day) AS avg_price_per_day
                FROM route
                GROUP BY route.destination_country');
            $stmt->execute();
            $data7 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 8:
            $stmt = $db->prepare('SELECT route.destination_country, 
                MIN(route.transport_price) AS min_transport_price, 
                MAX(route.transport_price) AS max_transport_price
                FROM route
                GROUP BY route.destination_country');
            $stmt->execute();
            $data8 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 9:
            $stmt = $db->prepare('SELECT route.*, trip.id AS trip_id FROM route JOIN trip ON route.id = trip.route_id WHERE trip.target = "Лечение" ORDER BY route.id ASC');
            $stmt->execute();
            $data9 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 10:
            $successMessage = '';
            $dataType = $_POST['data_type'];
            if ($dataType == 'user') {
                // Добавление данных в таблицу user
                $stmt = $db->prepare('INSERT INTO user (name, gender, birthday, birthplace, num_document, validity_doc) VALUES (?, ?, ?, ?, ?, ?)');
                if ($stmt->execute([$_POST['name'], $_POST['gender'], $_POST['birthday'], $_POST['birthplace'], $_POST['num_document'], $_POST['validity_doc']])) {
                    $successMessage = 'Данные успешно добавлены в таблицу "user".';
                } else {
                    $errorMessages[] = 'Ошибка при добавлении данных в таблицу "user".';
                }
            } elseif ($dataType == 'route') {
                // Добавление данных в таблицу route
                $stmt = $db->prepare('INSERT INTO route (destination_country, price_per_day, visa_price, transport_price) VALUES (?, ?, ?, ?)');
                if ($stmt->execute([$_POST['destination_country'], $_POST['price_per_day'], $_POST['visa_price'], $_POST['transport_price']])) {
                    $successMessage = 'Данные успешно добавлены в таблицу "route".';
                } else {
                    $errorMessages[] = 'Ошибка при добавлении данных в таблицу "route".';
                }
            } elseif ($dataType == 'trip') {
                // Добавление данных в таблицу trip
                $stmt = $db->prepare('INSERT INTO trip (user_id, route_id, target, start_date, duration) VALUES (?, ?, ?, ?, ?)');
                if ($stmt->execute([$_POST['user_id'], $_POST['route_id'], $_POST['target'], $_POST['start_date'], $_POST['duration']])) {
                    $successMessage = 'Данные успешно добавлены в таблицу "trip".';
                } else {
                    $errorMessages[] = 'Ошибка при добавлении данных в таблицу "trip".';
                }
            }

        default:
            break;
    }

    include('form.php');
}
?>