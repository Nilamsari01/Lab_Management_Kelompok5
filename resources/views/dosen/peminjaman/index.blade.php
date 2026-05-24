@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Approval Peminjaman</h4>
                <a href="{{ route('alat.index') }}" class="btn btn-light btn-sm">Kembali ke Daftar Alat</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nama Pengguna</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjaman as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->user->name ?? 'Pengguna tidak terdaftar' }}</td>
                                    <td>{{ ucfirst($p->status) }}</td>
                                    <td>
                                        @if($p->status === 'pending')
                                            <a href="{{ route('dosen.peminjaman.approve', $p->id) }}" class="btn btn-success btn-sm me-2">Setujui</a>
                                            <a href="{{ route('dosen.peminjaman.reject', $p->id) }}" class="btn btn-danger btn-sm">Tolak</a>
                                        @else
                                            <span class="text-muted">Tidak ada aksi</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada peminjaman untuk diverifikasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection