<?php

use models\{Clients, Orders};

require_once '../php/init.php';
$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader, array(
    'cache' => false
));
try {
    $show = !empty($_GET['show']) ? $_GET['show'] : 'users';
    switch ($show) {
        case 'orders':
        {
            $data = ['orders' => Orders::all()];
            $template = 'orders';
            break;
        }
        case 'users':
        {
            $data = ['users' => Clients::all()];
            $template = 'users';
            break;
        }
    }

    echo $twig->render("$template.twig", $data);

} catch (PDOException $e) {
    echo 'Was broken';
    echo $e->getMessage();
    die;
}

