<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Peminjaman::with(['user', 'alat'])->get(),
        ], 200);
    }

    public function show(Peminjaman $peminjaman)
    {
        return response()->json([
            'status' => 'success',
            'data' => $peminjaman->load(['user', 'alat']),
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'alat_id' => 'required|integer|exists:alats,id',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $peminjaman = Peminjaman::create($validated);

        return response()->json([
            'status' => 'created',
            'data' => $peminjaman,
        ], 201);
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|integer|exists:users,id',
            'alat_id' => 'sometimes|integer|exists:alats,id',
            'jumlah_pinjam' => 'sometimes|integer|min:1',
            'tanggal_pinjam' => 'sometimes|date',
            'status' => 'sometimes|string|max:255',
        ]);

        $peminjaman->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $peminjaman,
        ], 200);
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Peminjaman berhasil dihapus',
        ], 200);
    }
}
