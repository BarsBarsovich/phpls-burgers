<?php

namespace controllers;

use models\Order;

class IndexController extends Controller
{
    public function index()
    {
        $this->renderView('index');
    }


    public function order()
    {
//        $email = $_POST['email'];
//        $phone = $_POST['phone'];
//        $name = $_POST['name'];
//
//        $street = $_POST['street'];
//        $home = $_POST['home'];
//        $part = $_POST['part'];
//        $flat = $_POST['appt'];
//        $floor = $_POST['floor'];
//        $comment = $_POST['comment'];

        $order = new Order();
        $order->getOrder();

    }




}
