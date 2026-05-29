<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PeminjamanController extends Controller
{
    public function index()
    {
        $data = Peminjaman::with(['details.alat', 'user'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('peminjaman.index', compact('data'));
    }

    public function create()
    {
        $alat = Alat::all();
        return view('peminjaman.create', compact('alat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alat_id' => 'required|array|min:1',
            'alat_id.*' => 'required|integer|exists:alats,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'nullable|integer|min:1',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $totalJumlah = 0;
        foreach ($request->alat_id as $alatId) {
            $totalJumlah += $request->input('jumlah.' . $alatId, 1);
        }

        $data = [
            'user_id' => Auth::id(),
            'alat_id' => $request->alat_id[0],
            'jumlah_pinjam' => $totalJumlah,
            'tanggal_pinjam' => now(),
            'status' => 'pending',
        ];

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('peminjaman/bukti', 'public');
        }

        $peminjaman = Peminjaman::create($data);

        foreach ($request->alat_id as $alatId) {
            DetailPeminjaman::create([
                'peminjaman_id' => $peminjaman->id,
                'alat_id' => $alatId,
                'jumlah' => $request->input('jumlah.' . $alatId, 1),
            ]);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Permintaan peminjaman berhasil diajukan.');
    }

    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== Auth::id()) {
            abort(403);
        }

        if ($peminjaman->status !== 'disetujui') {
            return back()->with('error', 'Pengembalian hanya dapat dilakukan untuk peminjaman yang sudah disetujui.');
        }

        $peminjaman->status = 'kembali';
        $peminjaman->save();

        return back()->with('success', 'Alat berhasil dikembalikan.');
    }
}
