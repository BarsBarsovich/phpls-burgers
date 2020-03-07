<?php

$email = $_POST['email'];
$phone = $_POST['phone'];
$name = $_POST['name'];

$street = $_POST['street'];
$home = $_POST['home'];
$part = $_POST['part'];
$flat = $_POST['appt'];
$floor = $_POST['floor'];
$comment = $_POST['comment'];

try {
    $pdo = new PDO('mysql://localhost:3306/burgers', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    echo $e->getMessage();
    die;
}

$data = $pdo->query("SELECT * FROM burgers.users where Email='" . $email . "'")->fetch();
$userId = null;

if ($data) {
    // если  пользователь существует
    echo 'Auth vau';
    $userId = $data['Id'];
    $address = $street . ' ' . $home . ' ' . $part . ' ' . $floor . ' ' . $flat;
    addOrder($userId, $pdo, $address, $comment, $email);
} else {
    // если пользователя нет, создаем его
    $pdo->query("insert into burgers.users (Email, Phone, Name) values('" . $email . "','" . $phone . "','" . $name . "')");
    $res = $pdo->query('select last_insert_id() as id')->fetch();
    $userId = $res['id'];
    $address = $street . ' ' . $home . ' ' . $part . ' ' . $floor . ' ' . $flat;
    addOrder($userId, $pdo, $address, $comment, $email);
}


function addOrder($userId, $pdo, $address, $comment, $email)
{
    if ($userId) {
        // добавляем инфу о заказе
        $pdo->query("insert into burgers.orders(USER_ID, ADDRESS, COMMENT) values (" . $userId . ",'" . $address . "','" . $comment . "')");
        $res = $pdo->query('select last_insert_id() as id')->fetch();
        $orderId = $res['id'];

        $res = $pdo->query('select  count(*) as res from burgers.orders where USER_ID =' . $userId)->fetch();
        $count = $res['res'];
        sendMail($email, $orderId, $address, $count);
    }
}

function sendMail($email, $orderId, $address, $count)
{
    $subject = 'Заголовок - заказ № ' . $orderId;
    $message = 'Ваш заказ будет доставлен по адресу ' . $address . PHP_EOL;
    $message = $message . 'Товары для доставки: DarkBeefBurger за 500 рублей, 1 шт.' . PHP_EOL;
    if ($count > 1) {
        $message = $message . 'Спасибо! Это уже ' . $count . ' заказ';
    } else {
        $message = $message . 'Спасибо - это ваш первый заказ';
    }
    mail($email, $subject, $message);
}
