<?php

namespace App\Http\Controllers;

use App\Models\Alat;
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