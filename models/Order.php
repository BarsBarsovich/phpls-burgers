<?php

namespace models;

use PDO;
use PDOException;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Order
{
    protected $email = '';
    private $phone = '';
    private $name = '';
    private $street = '';
    private $home = '';
    private $part = '';
    private $flat = '';
    private $floor = '';
    private $comment = '';

    public function __construct()
    {
        $this->email = $_POST['email'];
        $this->phone = $_POST['phone'];
        $this->name = $_POST['name'];

        $this->street = $_POST['street'];
        $this->home = $_POST['home'];
        $this->part = $_POST['part'];
        $this->flat = $_POST['appt'];
        $this->floor = $_POST['floor'];
        $this->comment = $_POST['comment'];
    }

    public function getOrder()
    {
        try {
            $pdo = new PDO('mysql://localhost:3306/burgers', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }

        $query = $pdo->prepare("SELECT * FROM burgers.users where `Email`=:email");

        $query->execute(['email' => $this->email]);
        $data = $query->fetch();
        $userId = null;

        if ($data) {
            $userId = $data['Id'];
        } else {
            $query = $pdo->prepare("insert into burgers.users (Email, Phone, Name) values(:email, :phone, :name)");
            $query->execute(['email' => $this->email, 'phone' => $this->phone, 'name' => $this->name]);
            $res = $pdo->query('select last_insert_id() as id')->fetch();
            $userId = $res['id'];
        }

        $address = $this->street . ' ' . $this->home . ' ' . $this->part . ' ' . $this->floor . ' ' . $this->flat;
        $this->addOrder($userId, $pdo, $address, $this->comment, $email);
    }


    private function addOrder($userId, $pdo, $address, $comment, $email)
    {
        if ($userId) {
            // добавляем инфу о заказе
            $query = $pdo->prepare("insert into burgers.orders(USER_ID, ADDRESS, COMMENT) values (:userId, :address, :comment)");
            $query->execute(['userId' => $userId, 'address' => $address, 'comment' => $comment]);


            $res = $pdo->query('select last_insert_id() as id')->fetch();
            $orderId = $res['id'];

            $query = $pdo->prepare('select  count(*) as res from burgers.orders where USER_ID =:userId');
            $query->execute(['userId' => $userId]);
            $res = $query->fetch();

            $count = $res['res'];
            $this->sendMail($email, $orderId, $address, $count);
        }
    }

    private function sendMail($email, $orderId, $address, $count)
    {
        $subject = 'Заголовок - заказ № ' . $orderId;
        $message = 'Ваш заказ будет доставлен по адресу ' . $address . PHP_EOL;
        $message = $message . 'Товары для доставки: DarkBeefBurger за 500 рублей, 1 шт.' . PHP_EOL;
        if ($count > 1) {
            $message = $message . 'Спасибо! Это уже ' . $count . ' заказ';
        } else {
            $message = $message . 'Спасибо - это ваш первый заказ';
        }
        require_once './vendor/autoload.php';


        $transport = (new Swift_SmtpTransport('smtp.mail.ru', 25))
            ->setUsername('bars.bars.2021')
            ->setPassword('uPiUODa&u2t2');

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message($subject))
            ->setFrom(['bars.bars.2021@mail.ru' => 'bars.bars.2021@mail.ru'])
            ->setTo(['bars.bars.2021@mail.ru' => $this->name])
            ->setBody($message);

        // Send the message
        $result = $mailer->send($message);
    }
}