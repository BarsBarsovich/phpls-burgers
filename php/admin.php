<?php

try {
    $pdo = new PDO('mysql://localhost:3306/burgers', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $data = $pdo->query("SELECT * FROM burgers.users")->fetchAll();
    foreach ($data as $row) {
        echo $row['Name']."<br />\n";
    }
} catch (PDOException $e) {
    echo 'Was broken';
    echo $e->getMessage();
    die;
}
