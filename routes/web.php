<?php

use Illuminate\Support\Facades\Route;
use App\Models\Alat;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\SoapLabController;
use App\Http\Controllers\Dosen\PeminjamanApprovalController;

Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'dosen' => redirect()->route('dosen.dashboard'),
            'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
            default => redirect()->route('alat.index'),
        };
    }

    return redirect()->route('alat.index');
});

// Publik bisa melihat daftar alat, detail alat, dan daftar kategori
Route::get('alat', [AlatController::class, 'index'])->name('alat.index');
Route::get('alat/{alat}', [AlatController::class, 'show'])->name('alat.show')->whereNumber('alat');
Route::get('kategori', [KategoriController::class, 'index'])->name('kategori.index');

// CRUD Web untuk Alat dan Kategori
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('alat', AlatController::class)->except(['index', 'show']);
    Route::resource('kategori', KategoriController::class)->except(['index']);

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
        Route::post('users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    });
});

// Peminjaman hanya untuk mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::resource('peminjaman', PeminjamanController::class)->only(['index', 'create', 'store']);
    Route::patch('peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
});

// Approval peminjaman oleh dosen dan admin
Route::middleware(['auth', 'role:admin,dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('peminjaman', [PeminjamanApprovalController::class, 'index'])->name('peminjaman.index');
    Route::get('peminjaman/{id}/approve', [PeminjamanApprovalController::class, 'approve'])->name('peminjaman.approve');
    Route::get('peminjaman/{id}/reject', [PeminjamanApprovalController::class, 'reject'])->name('peminjaman.reject');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        $alats = Alat::all();
        return view('dashboard.admin', compact('alats'));
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dosen', function () {
        $alats = Alat::all();
        return view('dashboard.dosen', compact('alats'));
    })->name('dosen.dashboard');
});

Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa', function () {
        $alats = Alat::all();
        return view('dashboard.mahasiswa', compact('alats'));
    })->name('mahasiswa.dashboard');
});

// Route untuk auth
require __DIR__.'/auth.php';

// Route untuk SOAP Web Service
Route::any('/soap-service', [SoapLabController::class, 'handleSoap']);