<?php
require_once '../php/init.php';

use Illuminate\Database\Capsule\Manager as DB;
use models\{Clients, Orders};

$email = $_POST['email'];
$phone = $_POST['phone'];
$name = $_POST['name'];

$street = $_POST['street'];
$home = $_POST['home'];
$part = $_POST['part'];
$flat = $_POST['appt'];
$floor = $_POST['floor'];
$comment = $_POST['comment'];

$result = null;
$result = DB::table('clients')->where('email', '=', $email)->get();

if (count($result)) {
    // если  пользователь существует
    $userId = $result[0]->id;
    $address = $street . ' ' . $home . ' ' . $part . ' ' . $floor . ' ' . $flat;
} else {
    // если пользователя нет, создаем его
    $userParams = [
        "email" => $email,
        "name" => $name,
        "phone" => $phone
    ];
    $newUser = Clients::create($userParams);
    $userId = $newUser->id;

}
$address = $street . ' ' . $home . ' ' . $part . ' ' . $floor . ' ' . $flat;
addOrder($userId, $address, $comment, $email);


function addOrder($userId, $address, $comment, $email)
{
    if ($userId) {

        // добавляем инфу о заказе
        $orderInfo = [
            'client_id' => $userId,
            'address' => $address,
            'comment' => $comment
        ];
        $newOrder = Orders::create($orderInfo);


        $rowsCount = DB::table('orders')->where('client_id','=', $userId)->count();

        sendMail($email, $newOrder->id, $address, $rowsCount);
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
