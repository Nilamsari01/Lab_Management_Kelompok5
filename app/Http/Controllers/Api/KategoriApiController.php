<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Kategori::orderBy('nama')->get(),
        ], 200);
    }

    public function show(Kategori $kategori)
    {
        return response()->json([
            'status' => 'success',
            'data' => $kategori,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategori = Kategori::create($validated);

        return response()->json([
            'status' => 'created',
            'data' => $kategori,
        ], 201);
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategori->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $kategori,
        ], 200);
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil dihapus',
        ], 200);
    }
}
