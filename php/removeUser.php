<?php
require_once '../php/init.php';

use Illuminate\Database\Capsule\Manager as DB;

$orders = DB::table('orders')->where('client_id', '=', $_GET['id'])->count();
if ($orders) {
    echo 'Данного пользователя удалить нельзя, у него есть заказы';
    return;
}
$user = DB::table('clients')->where('id', '=', $_GET['id'])->delete();
echo 'Пользователь удален';


