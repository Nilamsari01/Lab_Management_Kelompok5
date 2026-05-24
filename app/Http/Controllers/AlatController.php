<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlatController extends Controller {
    public function index() {
        $alats = Alat::all();
        return view('alat.index', compact('alats'));
    }

    public function show(Alat $alat) {
        return view('alat.show', compact('alat'));
    }

    public function create() {
        return view('alat.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nama_alat' => 'required',
            'kategori' => 'required',
            'stok' => 'required|integer',
            'lokasi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['nama_alat', 'kategori', 'stok', 'lokasi']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('alats', 'public');
        }

        Alat::create($data);
        return redirect()->route('alat.index')->with('success', 'Alat laboratorium berhasil ditambahkan!');
    }

    public function edit(Alat $alat) {
        return view('alat.edit', compact('alat'));
    }

    public function update(Request $request, Alat $alat) {
        $request->validate([
            'nama_alat' => 'required',
            'kategori' => 'required',
            'stok' => 'required|integer',
            'lokasi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['nama_alat', 'kategori', 'stok', 'lokasi']);

        if ($request->hasFile('gambar')) {
            if ($alat->gambar && Storage::disk('public')->exists($alat->gambar)) {
                Storage::disk('public')->delete($alat->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('alats', 'public');
        }

        $alat->update($data);
        return redirect()->route('alat.index')->with('success', 'Data alat berhasil diperbarui!');
    }

    public function destroy(Alat $alat) {
        $alat->delete();
        return redirect()->route('alat.index')->with('success', 'Alat berhasil dihapus!');
    }
}