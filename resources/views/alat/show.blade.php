@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Detail Alat</h4>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ $alat->gambar_url }}" alt="{{ $alat->nama_alat }}" class="img-fluid rounded" style="max-height: 320px; object-fit: cover; width: 100%;">
                </div>
                <dl class="row">
                    <dt class="col-sm-4">Nama Alat</dt>
                    <dd class="col-sm-8">{{ $alat->nama_alat }}</dd>

                    <dt class="col-sm-4">Kategori</dt>
                    <dd class="col-sm-8">{{ $alat->kategori }}</dd>

                    <dt class="col-sm-4">Stok</dt>
                    <dd class="col-sm-8">{{ $alat->stok }} unit</dd>

                    <dt class="col-sm-4">Lokasi</dt>
                    <dd class="col-sm-8">{{ $alat->lokasi }}</dd>
                </dl>
                <a href="{{ route('alat.index') }}" class="btn btn-secondary">Kembali ke Daftar Alat</a>
            </div>
        </div>
    </div>
</div>
@endsection
