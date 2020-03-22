<?php

require_once '../php/init.php';

use models\Clients;

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader, array(
    'cache' => false
));

$userId = $_GET['id'];
$name = $_GET['name'];
$email = $_GET['email'];
$phone = $_GET['phone'];
$mode = $_GET['mode'];

$data = [];

switch ($mode) {
    case 'saveAfterEdit':
        $client = Clients::where('id', $userId)->update(
            [
                'name' => $name,
                'email' => $email,
                'phone' => $phone
            ]
        );
        break;
    case 'saveNewUser':
        $params = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];
        $result = Clients::create($params);
        break;
    case 'edit':
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'mode' => 'edit',
            'id' => $userId
        ];
        break;
}

echo $twig->render("user.twig", $data);