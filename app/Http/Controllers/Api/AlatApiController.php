<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;

class AlatApiController extends Controller
{
    public function index()
    {
        $alat = Alat::all()->each->append('gambar_url');

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar alat laboratorium berhasil diambil',
            'data' => $alat
        ], 200);
    }

    public function show(Alat $alat)
    {
        $alat->append('gambar_url');

        return response()->json([
            'status' => 'success',
            'data' => $alat
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'lokasi' => 'required|string|max:255',
        ]);

        $alat = Alat::create($validated);

        return response()->json([
            'status' => 'created',
            'message' => 'Alat baru berhasil ditambahkan via API',
            'data' => $alat
        ], 201);
    }

    public function update(Request $request, Alat $alat)
    {
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'lokasi' => 'required|string|max:255',
        ]);

        $alat->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Data alat berhasil diperbarui via API',
            'data' => $alat
        ], 200);
    }

    public function destroy(Alat $alat)
    {
        $alat->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Alat berhasil dihapus via API'
        ], 200);
    }
}
