<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'Lab_Management');
if ($mysqli->connect_error) {
    echo "DBERR: " . $mysqli->connect_error . PHP_EOL;
    exit(1);
}
$res = $mysqli->query('SELECT id, nama_alat, gambar FROM alats LIMIT 10');
if (! $res) {
    echo "QUERYERR: " . $mysqli->error . PHP_EOL;
    exit(1);
}
while ($row = $res->fetch_assoc()) {
    echo $row['id'] . ' | ' . $row['nama_alat'] . ' => ' . ($row['gambar'] ?? 'NULL') . PHP_EOL;
}
