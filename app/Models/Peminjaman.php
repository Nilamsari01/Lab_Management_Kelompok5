<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Peminjaman extends Model {
    use HasFactory;

    protected $table = 'peminjamans';
    protected $fillable = ['user_id', 'alat_id', 'jumlah_pinjam', 'tanggal_pinjam', 'status', 'bukti'];
    protected $appends = ['bukti_url'];

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

    public function getBuktiUrlAttribute(): ?string
    {
        if (! $this->bukti) {
            return null;
        }

        if (filter_var($this->bukti, FILTER_VALIDATE_URL)) {
            return $this->bukti;
        }

        return Storage::disk('public')->url($this->bukti);
    }
}
