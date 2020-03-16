<?php





$query = $pdo->prepare("SELECT * FROM burgers.users where `Email`=:email");

$query->execute(['email'=> $email]);
$data = $query-> fetch();
$userId = null;

if ($data) {
    // если  пользователь существует
    echo 'Auth vau';
    $userId = $data['Id'];
    $address = $street . ' ' . $home . ' ' . $part . ' ' . $floor . ' ' . $flat;
    addOrder($userId, $pdo, $address, $comment, $email);
} else {
    // если пользователя нет, создаем его
    $query = $pdo->prepare ("insert into burgers.users (Email, Phone, Name) values(:email, :phone, :name)");
    $query -> execute(['email'=> $email, 'phone'=> $phone , 'name'=> $name]);

    $res = $pdo->query('select last_insert_id() as id')->fetch();
    $userId = $res['id'];
    echo 'Created USer ID '.$userId;
    $address = $street . ' ' . $home . ' ' . $part . ' ' . $floor . ' ' . $flat;
    addOrder($userId, $pdo, $address, $comment, $email);
}

