<?php
require __DIR__.'/vendor/autoload.php';
$config = require __DIR__.'/config/database.php';
$db = $config['connections']['mysql'];
$pdo = new PDO('mysql:host='.$db['host'].';dbname='.$db['database'].';charset='.$db['charset'], $db['username'], $db['password']);
$stmt = $pdo->query('select id,email,role,password from users');
foreach ($stmt as $row) {
    echo $row['id'].' | '.$row['email'].' | '.$row['role'].' | '.$row['password'].'\n';
}
