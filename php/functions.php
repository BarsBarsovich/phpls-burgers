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
