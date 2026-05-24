@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Dashboard Mahasiswa</h4>
            </div>
            <div class="card-body">
                <p>Selamat datang, Mahasiswa. Gunakan menu di bawah untuk mengajukan peminjaman alat dan melihat riwayat peminjaman Anda.</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
                    <h5 class="card-title">Ajukan Peminjaman</h5>
                    <p class="card-text">Pilih alat yang ingin dipinjam dan submit permintaan.</p>
                </div>
                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mt-3">Ajukan Sekarang</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
                    <h5 class="card-title">Riwayat Peminjaman</h5>
                    <p class="card-text">Lihat status, detail, dan keputusan persetujuan peminjaman Anda.</p>
                </div>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary mt-3">Lihat Riwayat</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    @include('dashboard.alats')
</div>
@endsection
