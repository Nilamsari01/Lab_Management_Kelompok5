<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlatApiController;
use App\Http\Controllers\Api\KategoriApiController;
use App\Http\Controllers\Api\PeminjamanApiController;

Route::apiResource('alat', AlatApiController::class);
Route::apiResource('kategori', KategoriApiController::class);
Route::apiResource('peminjaman', PeminjamanApiController::class);