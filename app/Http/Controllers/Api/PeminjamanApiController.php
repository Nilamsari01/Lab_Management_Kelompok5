<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;

class PeminjamanApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'details.alat']);

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        return response()->json([
            'status' => 'success',
            'data' => $query->orderByDesc('created_at')->get(),
        ], 200);
    }

    public function show(Peminjaman $peminjaman)
    {
        return response()->json([
            'status' => 'success',
            'data' => $peminjaman->load(['user', 'details.alat']),
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'status' => 'required|string|in:pending,disetujui,ditolak,kembali',
            'details' => 'required_without:alat_id|array',
            'details.*.alat_id' => 'required_with:details|integer|exists:alats,id',
            'details.*.jumlah' => 'required_with:details|integer|min:1',
            'alat_id' => 'required_without:details|integer|exists:alats,id',
            'jumlah_pinjam' => 'required_without:details|integer|min:1',
            'bukti' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $details = [];
        if ($request->filled('details')) {
            foreach ($request->input('details', []) as $detail) {
                $details[] = [
                    'alat_id' => $detail['alat_id'],
                    'jumlah' => $detail['jumlah'],
                ];
            }
        } else {
            $details[] = [
                'alat_id' => $request->input('alat_id'),
                'jumlah' => $request->input('jumlah_pinjam'),
            ];
        }

        $firstAlatId = $details[0]['alat_id'];
        $totalJumlah = array_sum(array_column($details, 'jumlah'));

        $payload = [
            'user_id' => $validated['user_id'],
            'alat_id' => $firstAlatId,
            'jumlah_pinjam' => $totalJumlah,
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'status' => $validated['status'],
        ];

        if ($request->hasFile('bukti')) {
            $payload['bukti'] = $request->file('bukti')->store('peminjaman/bukti', 'public');
        }

        $peminjaman = Peminjaman::create($payload);

        foreach ($details as $detail) {
            DetailPeminjaman::create([
                'peminjaman_id' => $peminjaman->id,
                'alat_id' => $detail['alat_id'],
                'jumlah' => $detail['jumlah'],
            ]);
        }

        return response()->json([
            'status' => 'created',
            'data' => $peminjaman->load('details.alat'),
        ], 201);
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|integer|exists:users,id',
            'tanggal_pinjam' => 'sometimes|date',
            'status' => 'sometimes|string|in:pending,disetujui,ditolak,kembali',
            'details' => 'sometimes|array',
            'details.*.alat_id' => 'required_with:details|integer|exists:alats,id',
            'details.*.jumlah' => 'required_with:details|integer|min:1',
            'bukti' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('bukti')) {
            $validated['bukti'] = $request->file('bukti')->store('peminjaman/bukti', 'public');
        }

        $peminjaman->update($validated);

        if ($request->filled('details')) {
            $peminjaman->details()->delete();
            $details = $request->input('details');
            $totalJumlah = 0;

            foreach ($details as $detail) {
                $totalJumlah += $detail['jumlah'];
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id' => $detail['alat_id'],
                    'jumlah' => $detail['jumlah'],
                ]);
            }

            $peminjaman->update(['jumlah_pinjam' => $totalJumlah, 'alat_id' => $details[0]['alat_id']]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $peminjaman->load('details.alat'),
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
