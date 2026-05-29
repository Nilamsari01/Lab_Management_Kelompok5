<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Alat extends Model {
    use HasFactory;

    protected $fillable = ['nama_alat', 'kategori', 'stok', 'lokasi', 'gambar'];
    protected $appends = ['gambar_url'];

    // Relasi OOP: Satu alat bisa memiliki banyak riwayat peminjaman
    public function peminjamans() {
        return $this->hasMany(Peminjaman::class);
    }

    public function getGambarUrlAttribute(): string
    {
        if (! $this->gambar) {
            return 'https://via.placeholder.com/400x240?text=Tanpa+Gambar';
        }

        if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
            return $this->gambar;
        }

        return Storage::disk('public')->url($this->gambar);
    }
}