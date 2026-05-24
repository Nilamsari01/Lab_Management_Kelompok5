<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model {
    use HasFactory;

    protected $table = 'peminjamans';
    protected $fillable = ['user_id', 'alat_id', 'jumlah_pinjam', 'tanggal_pinjam', 'status'];

    // Relasi OOP: Peminjaman ini dimiliki oleh User tertentu
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi OOP: Peminjaman ini merujuk pada Alat tertentu
    public function alat() {
        return $this->belongsTo(Alat::class);
    }

    // Relasi OOP: Detail peminjaman menyimpan item alat yang dipinjam
    public function details() {
        return $this->hasMany(DetailPeminjaman::class);
    }
}