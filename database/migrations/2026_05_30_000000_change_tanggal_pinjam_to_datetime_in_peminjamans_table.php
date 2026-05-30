<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasColumn('peminjamans', 'tanggal_pinjam')) {
            DB::statement('ALTER TABLE `peminjamans` CHANGE `tanggal_pinjam` `tanggal_pinjam` DATETIME NOT NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('peminjamans', 'tanggal_pinjam')) {
            DB::statement('ALTER TABLE `peminjamans` CHANGE `tanggal_pinjam` `tanggal_pinjam` DATE NOT NULL');
        }
    }
};
