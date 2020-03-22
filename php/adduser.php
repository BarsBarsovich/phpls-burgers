<?php
$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader, array(
    'cache' => false
));

$userId = $_GET['id'];
echo $twig->render("user.twig", $data);