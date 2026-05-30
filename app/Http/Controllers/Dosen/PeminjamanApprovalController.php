<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanApprovalController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('user')->get();
        return view('dosen.peminjaman.index', compact('peminjaman'));
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::with('details.alat')->findOrFail($id);

        if ($peminjaman->status === 'disetujui') {
            return back()->with('error', 'Permintaan peminjaman sudah disetujui.');
        }

        if ($peminjaman->status === 'ditolak') {
            return back()->with('error', 'Permintaan peminjaman sudah ditolak.');
        }

        if ($peminjaman->status === 'kembali') {
            return back()->with('error', 'Permintaan peminjaman sudah dikembalikan.');
        }

        try {
            DB::transaction(function () use ($peminjaman) {
                foreach ($peminjaman->details as $detail) {
                    $updated = DB::table('alats')
                        ->where('id', $detail->alat_id)
                        ->where('stok', '>=', $detail->jumlah)
                        ->decrement('stok', $detail->jumlah);

                    if ($updated === 0) {
                        $alat = Alat::find($detail->alat_id);
                        $stok = $alat ? $alat->stok : 0;
                        throw new \Exception("Stok untuk '{$alat?->nama_alat}' tidak mencukupi. Saat ini tersedia {$stok}.");
                    }
                }

                $peminjaman->status = 'disetujui';
                $peminjaman->save();
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

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
