@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">📚 Inventaris Alat Laboratorium</h2>
                <p class="text-muted">Total: <strong>{{ count($alats) }}</strong> alat tersedia</p>
            </div>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('alat.create') }}" class="btn btn-success btn-sm">+ Tambah Alat Baru</a>
                @endif
            @endauth
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <!-- .table-responsive menjamin UI ramah mobile/tidak pecah di smartphone -->
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <tr>
                                <th class="border-0">No</th>
                                <th class="border-0">Nama Alat</th>
                                <th class="border-0">Kategori</th>
                                <th class="border-0">Stok</th>
                                <th class="border-0">Lokasi Rak</th>
                                @auth
                                    @if(auth()->user()->role === 'admin')
                                        <th class="border-0">Aksi</th>
                                    @endif
                                @endauth
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($alats as $index => $a)
                            <tr style="border-bottom: 1px solid #e0e0e0;">
                                <td class="fw-bold text-primary">{{ $index + 1 }}</td>
                                <td><strong>{{ $a->nama_alat }}</strong></td>
                                <td><span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">{{ $a->kategori }}</span></td>
                                <td>
                                    <span class="badge" style="background-color: {{ $a->stok > 5 ? '#28a745' : ($a->stok > 0 ? '#ffc107' : '#dc3545') }};">
                                        {{ $a->stok }} Pcs
                                    </span>
                                </td>
                                <td>{{ $a->lokasi }}</td>
                                @auth
                                    @if(auth()->user()->role === 'admin')
                                        <td>
                                            <form action="{{ route('alat.destroy', $a->id) }}" method="POST" style="display: inline;">
                                                <a href="{{ route('alat.edit', $a->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus alat ini?')">Hapus</button>
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