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

$query = $pdo->prepare("SELECT * FROM burgers.users where `Email`=:email");

$query->execute(['email'=> $email]);
$data = $query-> fetch();
$userId = null;

if ($data) {
    // если  пользователь существует
    echo 'Auth vau';
    $userId = $data['Id'];
    $address = $street . ' ' . $home . ' ' . $part . ' ' . $floor . ' ' . $flat;
    addOrder($userId, $pdo, $address, $comment, $email);
} else {
    // если пользователя нет, создаем его
    $query = $pdo->prepare ("insert into burgers.users (Email, Phone, Name) values(:email, :phone, :name)");
    $query -> execute(['email'=> $email, 'phone'=> $phone , 'name'=> $name]);

    $res = $pdo->query('select last_insert_id() as id')->fetch();
    $userId = $res['id'];
    echo 'Created USer ID '.$userId;
    $address = $street . ' ' . $home . ' ' . $part . ' ' . $floor . ' ' . $flat;
    addOrder($userId, $pdo, $address, $comment, $email);
}


function addOrder($userId, $pdo, $address, $comment, $email)
{
    if ($userId) {
        // добавляем инфу о заказе
        $query = $pdo->prepare("insert into burgers.orders(USER_ID, ADDRESS, COMMENT) values (:userId, :address, :comment)");
        $query-> execute(['userId'=> $userId, 'address'=> $address, 'comment'=> $comment]);


        $res = $pdo->query('select last_insert_id() as id')->fetch();
        $orderId = $res['id'];

        $query = $pdo->prepare('select  count(*) as res from burgers.orders where USER_ID =:userId');
        $query-> execute(['userId'=> $userId]);
        $res = $query-> fetch();

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
