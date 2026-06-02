@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2>Daftar Peminjaman</h2>
                <small class="text-muted" id="last-updated">Diperbarui baru saja</small>
            </div>
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">Ajukan Peminjaman</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Pengguna</th>
                                <th>Alat</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->user->name ?? 'Guest' }}</td>
                                    <td>
                                        @if($item->details->isNotEmpty())
                                            @foreach($item->details as $detail)
                                                {{ $detail->alat->nama_alat ?? 'Tidak tersedia' }} ({{ $detail->jumlah }})<br>
                                            @endforeach
                                        @else
                                            {{ $item->alat->nama_alat ?? 'Tidak tersedia' }}
                                        @endif
                                    </td>
                                    <td>{{ $item->details->sum('jumlah') ?: $item->jumlah_pinjam }}</td>
                                    @php
                                        $tanggalPinjam = $item->tanggal_pinjam;

                                        if ($tanggalPinjam->format('H:i') === '00:00' && $item->created_at) {
                                            $tanggalPinjam = $item->created_at;
                                        }
                                    @endphp
                                    <td>{{ $tanggalPinjam->format('d M Y H:i') }}</td>
                                    <td>
                                        {{ ucfirst($item->status) }}
                                        @if($item->bukti_url)
                                            <div><a href="{{ $item->bukti_url }}" target="_blank" class="small">Lihat Bukti</a></div>
                                        @endif
                                        @if($item->status === 'disetujui')
                                            <form action="{{ route('peminjaman.kembalikan', $item) }}" method="POST" class="d-inline ms-2">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-warning">Kembalikan</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada riwayat peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Auto-refresh setiap 30 detik -->
<script>
    let secondsAgo = 0;
    const REFRESH_INTERVAL = 30000; // 30 detik
    
    // Update tampilan "diperbarui X detik lalu"
    function updateTimestamp() {
        secondsAgo++;
        const el = document.getElementById('last-updated');
        if (secondsAgo < 60) {
            el.textContent = `Diperbarui ${secondsAgo} detik lalu`;
        } else {
            el.textContent = `Diperbarui ${Math.floor(secondsAgo / 60)} menit lalu`;
        }
    }
    
    // Update setiap detik
    setInterval(updateTimestamp, 1000);
    
    // Refresh halaman setiap 30 detik
    setInterval(() => {
        location.reload();
    }, REFRESH_INTERVAL);
</script>
@endsection
