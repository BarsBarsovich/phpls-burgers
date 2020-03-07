<?php

try {
    $pdo = new PDO('mysql://localhost:3306/burgers', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $data = $pdo->query("SELECT * FROM burgers.users")->fetchAll();
    echo '<p> Пользователи </p>';
    echo '<table border="1px solid">';
    echo '<tr><td>UserName</td><td>Email</td></tr>';
    foreach ($data as $row) {
        echo '<tr><td>' .
            $row['Name'] . '</td><td>' . $row['Email'] . '</td></tr>';
    }
    echo '</table>';

    echo 'Заказы';
    $orders = $pdo->query("SELECT * FROM burgers.orders")->fetchAll();
    echo '<table border="1px solid">';
    echo '<tr><td>ID</td><td>USER_ID</td><td>ADDRESS</td><td>COMMENT</td></tr>';

    foreach ($orders as $row) {
        echo '<tr><td>' . $row['USER_ID'] . '</td><td>' . $row['ID'] . '</td><td>' . $row['ADDRESS'] .
            '</td><td>' . $row['COMMENT'] . '</td></tr>';
    }
    echo '</table>';

} catch (PDOException $e) {
    echo 'Was broken';
    echo $e->getMessage();
    die;
}
