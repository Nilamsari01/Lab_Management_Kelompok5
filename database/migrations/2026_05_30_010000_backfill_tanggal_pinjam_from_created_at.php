<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("UPDATE `peminjamans` SET `tanggal_pinjam` = CONCAT(DATE(`tanggal_pinjam`), ' ', TIME(`created_at`)) WHERE TIME(`tanggal_pinjam`) = '00:00:00'");
    }

    public function down(): void
    {
        // No rollback for historical timestamp backfill
    }
};
