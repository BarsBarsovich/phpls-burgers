<?php

require_once "./vendor/autoload.php";
$uri = explode('/', str_replace('mvc/', '', $_SERVER['REQUEST_URI']));

array_shift($uri);
list($controllerName, $action) = [$uri[0], $uri[1]];

$controllerName = !empty($controllerName) ? $controllerName : 'index';
$controllerName = stristr($controllerName,
    'Controller') ? $controllerName : ucfirst($controllerName) . 'Controller';
$controllerName = 'controllers\\' . $controllerName;

$userData = !empty($_REQUEST) ? $_REQUEST : [];

try {
    $controller = new $controllerName($userData);
    $action = empty($action) ? 'index' : $action;
    $controller->$action();
} catch (Exception $exception) {
    echo $exception->getMessage();
} finally {
    $html = $controller->hasView() ? $controller->getView() : '';
    echo !empty($response) ? $response : $html;
}