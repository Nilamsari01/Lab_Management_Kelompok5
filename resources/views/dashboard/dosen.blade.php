@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h4 class="mb-0">Dashboard Dosen</h4>
            </div>
            <div class="card-body">
                <p>Selamat datang, Dosen. Di sini Anda dapat memeriksa dan menyetujui peminjaman alat laboratorium.</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    @include('dashboard.alats')
</div>
@endsection
