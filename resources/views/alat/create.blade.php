@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-sm-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Form Tambah Alat</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('alat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" placeholder="Contoh: Kaca, Elektronik" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok Masuk</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi Penyimpanan</label>
                        <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Rak A-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar Alat (opsional)</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                        <div class="form-text">Pilih gambar dari perangkat untuk ditampilkan di dashboard.</div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('alat.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-success">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection