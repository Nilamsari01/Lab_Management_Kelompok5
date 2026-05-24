<?php
$env = [];
foreach (preg_split('/\r?\n/', trim(file_get_contents(__DIR__.'/.env'))) as $line) {
    if ($line === '' || $line[0] === '#') {
        continue;
    }
    $parts = explode('=', $line, 2);
    $env[$parts[0]] = $parts[1] ?? '';
}
$pdo = new PDO('mysql:host='.$env['DB_HOST'].';port='.$env['DB_PORT'].';dbname='.$env['DB_DATABASE'].';charset=utf8mb4', $env['DB_USERNAME'], $env['DB_PASSWORD']);
$stmt = $pdo->query('SELECT id, email, role, password FROM users');
foreach ($stmt as $row) {
    echo $row['id'].' | '.$row['email'].' | '.$row['role'].' | '.$row['password'].'\n';
}
