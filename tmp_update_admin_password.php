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
$password = password_hash('Admin123!', PASSWORD_BCRYPT);
$stmt = $pdo->prepare('UPDATE users SET password = ? WHERE role = ?');
$stmt->execute([$password, 'admin']);
echo "Updated admin password to Admin123!\n";
