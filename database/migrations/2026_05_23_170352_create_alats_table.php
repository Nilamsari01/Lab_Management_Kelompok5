<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('alats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alat');
            $table->string('kategori');
            $table->integer('stok');
            $table->string('lokasi');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('alats');
    }
};