<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
        $validated = $request->validate([
            'alat_id' => 'required|array|min:1',
            'alat_id.*' => 'required|integer|exists:alats,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            $peminjaman = null;
            $totalJumlah = 0;

            DB::transaction(function () use ($validated, $request, &$peminjaman, &$totalJumlah) {
                $alats = Alat::whereIn('id', $validated['alat_id'])
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                $stockErrors = [];
                foreach ($validated['alat_id'] as $alatId) {
                    $requested = $validated['jumlah'][$alatId] ?? 0;
                    $alat = $alats->get($alatId);

                    if (! $alat) {
                        continue;
                    }

                    if ($requested > $alat->stok) {
                        $stockErrors[] = "Jumlah peminjaman untuk '{$alat->nama_alat}' tidak boleh lebih besar dari stok yang tersedia ({$alat->stok}).";
                    }
                }

                if (count($stockErrors) > 0) {
                    throw new \Exception(implode(' ', $stockErrors));
                }

                foreach ($validated['alat_id'] as $alatId) {
                    $totalJumlah += $validated['jumlah'][$alatId] ?? 0;
                }

                $data = [
                    'user_id' => Auth::id(),
                    'alat_id' => $validated['alat_id'][0],
                    'jumlah_pinjam' => $totalJumlah,
                    'tanggal_pinjam' => now()->timezone(config('app.timezone'))->toDateTimeString(),
                    'status' => 'pending',
                ];

                if ($request->hasFile('bukti')) {
                    $data['bukti'] = $request->file('bukti')->store('peminjaman/bukti', 'public');
                }

                $peminjaman = Peminjaman::create($data);

                foreach ($validated['alat_id'] as $alatId) {
                    DetailPeminjaman::create([
                        'peminjaman_id' => $peminjaman->id,
                        'alat_id' => $alatId,
                        'jumlah' => $validated['jumlah'][$alatId] ?? 1,
                    ]);
                }
            });
        } catch (\Exception $e) {
            return back()->withErrors([$e->getMessage()])->withInput();
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

        try {
            DB::transaction(function () use ($peminjaman) {
                foreach ($peminjaman->details as $detail) {
                    $alat = $detail->alat;

                    if (! $alat) {
                        continue;
                    }

                    $alat->stok += $detail->jumlah;
                    $alat->save();
                }

                $peminjaman->status = 'kembali';
                $peminjaman->save();
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengembalikan alat: ' . $e->getMessage());
        }

        return back()->with('success', 'Alat berhasil dikembalikan.');
    }
}
