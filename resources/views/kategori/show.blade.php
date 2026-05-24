@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Detail Kategori</h4>
            </div>
            <div class="card-body">
                <p><strong>Nama Kategori:</strong> {{ $kategori->nama }}</p>
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali ke Kategori</a>
            </div>
        </div>
    </div>
</div>
@endsection
