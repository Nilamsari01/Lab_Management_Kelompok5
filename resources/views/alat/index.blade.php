@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Inventaris Alat Laboratorium</h2>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('alat.create') }}" class="btn btn-primary btn-sm">Tambah Alat Baru</a>
                @endif
            @endauth
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <!-- .table-responsive menjamin UI ramah mobile/tidak pecah di smartphone -->
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Alat</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Lokasi Rak</th>
                                @auth
                                    @if(auth()->user()->role === 'admin')
                                        <th>Aksi</th>
                                    @endif
                                @endauth
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($alats as $index => $a)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $a->nama_alat }}</strong></td>
                                <td><span class="badge bg-secondary">{{ $a->kategori }}</span></td>
                                <td>{{ $a->stok }} Pcs</td>
                                <td>{{ $a->lokasi }}</td>
                                @auth
                                    @if(auth()->user()->role === 'admin')
                                        <td>
                                            <form action="{{ route('alat.destroy', $a->id) }}" method="POST">
                                                <a href="{{ route('alat.edit', $a->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus alat?')">Hapus</button>
                                            </form>
                                        </td>
                                    @endif
                                @endauth
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center p-4 text-muted">Belum ada data alat laboratorium.</td>
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