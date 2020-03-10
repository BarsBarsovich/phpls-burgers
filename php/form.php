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
    $userId = $data['Id'];
} else {
    // если пользователя нет, создаем его
    $query = $pdo->prepare ("insert into burgers.users (Email, Phone, Name) values(:email, :phone, :name)");
    $query -> execute(['email'=> $email, 'phone'=> $phone , 'name'=> $name]);

    $res = $pdo->query('select last_insert_id() as id')->fetch();
    $userId = $res['id'];
}
$address = $street . ' ' . $home . ' ' . $part . ' ' . $floor . ' ' . $flat;
require_once 'functions.php';
addOrder($userId, $pdo, $address, $comment, $email);



