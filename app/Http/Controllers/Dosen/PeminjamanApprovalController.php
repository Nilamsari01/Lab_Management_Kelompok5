<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanApprovalController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('user')->get();
        return view('dosen.peminjaman.index', compact('peminjaman'));
    }

    public function approve($id)
    {
        $data = Peminjaman::findOrFail($id);
        $data->status = 'disetujui';
        $data->save();

        return back()->with('success', 'Permintaan peminjaman telah disetujui.');
    }

    public function reject($id)
    {
        $data = Peminjaman::findOrFail($id);
        $data->status = 'ditolak';
        $data->save();

        return back()->with('success', 'Permintaan peminjaman telah ditolak.');
    }
}
