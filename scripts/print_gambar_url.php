<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Alat;
$alat = Alat::find(9);
if (! $alat) {
    echo "Alat not found\n";
    exit(1);
}

echo $alat->gambar_url . PHP_EOL;
