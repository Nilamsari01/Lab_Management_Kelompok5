@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Dashboard Admin</h4>
            </div>
            <div class="card-body">
                <p>Selamat datang, Admin. Gunakan menu untuk mengelola data dan melihat laporan sistem.</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary mt-3">Manajemen Akun Admin/Dosen</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    @include('dashboard.alats')
</div>
@endsection
