<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

// Kelas Logika Bisnis untuk SOAP
class SoapServiceLogic {
    public function getStokAlat($namaAlat) {
        $alat = Alat::where('nama_alat', 'LIKE', "%$namaAlat%")->first();
        if ($alat) {
            return "Stok alat '" . $alat->nama_alat . "' saat ini: " . $alat->stok . " unit di " . $alat->lokasi;
        }
        return "Alat tidak ditemukan di laboratorium.";
    }

    public function listAlat()
    {
        $tools = Alat::orderBy('nama_alat')->get(['nama_alat', 'kategori', 'stok', 'lokasi']);
        $result = [];

        foreach ($tools as $tool) {
            $result[] = sprintf("%s | %s | Stok: %s | Lokasi: %s", $tool->nama_alat, $tool->kategori, $tool->stok, $tool->lokasi);
        }

        return implode("\n", $result);
    }

    public function getPeminjamanStatusByUser($userId)
    {
        $loans = Peminjaman::where('user_id', $userId)->orderByDesc('tanggal_pinjam')->get();

        if ($loans->isEmpty()) {
            return "Tidak ditemukan peminjaman untuk pengguna dengan ID: $userId.";
        }

        $output = [];
        foreach ($loans as $loan) {
            $items = $loan->details->map(function ($detail) {
                return $detail->alat->nama_alat . ' (' . $detail->jumlah . ')';
            })->implode(', ');

            $output[] = sprintf("%s - %s - Status: %s", $loan->tanggal_pinjam, $items, $loan->status);
        }

        return implode("\n", $output);
    }

    public function getPeminjamanById($id)
    {
        $loan = Peminjaman::with('details.alat', 'user')->find($id);

        if (! $loan) {
            return "Peminjaman dengan ID $id tidak ditemukan.";
        }

        $items = $loan->details->map(function ($detail) {
            return $detail->alat->nama_alat . ' (' . $detail->jumlah . ')';
        })->implode(', ');

        return sprintf("ID: %s | Pengguna: %s | Alat: %s | Tanggal: %s | Status: %s", $loan->id, $loan->user->name, $items, $loan->tanggal_pinjam, $loan->status);
    }
}

class SoapLabController extends Controller {
    public function handleSoap() {
        // Matikan cache WSDL untuk keperluan development/lokal
        ini_set('soap.wsdl_cache_enabled', '0');

        // Setup Soap Server tanpa WSDL (Non-WSDL mode)
        $options = ['uri' => url('/soap-service')];
        $server = new \SoapServer(null, $options);
        
        // Daftarkan class logika ke dalam SOAP Server
        $server->setClass(SoapServiceLogic::class);

        // Render response sebagai format XML asli
        ob_start();
        $server->handle();
        $response = ob_get_clean();

        return response($response)->header('Content-Type', 'text/xml; charset=utf-8');
    }
}