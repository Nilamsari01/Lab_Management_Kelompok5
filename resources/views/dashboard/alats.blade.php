<div class="col-12">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Daftar Alat Laboratorium</h5>
            <p class="small text-muted mb-0">Lihat semua alat yang tersedia beserta gambar, kategori, stok, dan lokasi penyimpanan.</p>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @forelse($alats as $alat)
                    <div class="col-sm-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <img
                                src="{{ $alat->gambar_url }}"
                                onerror="this.onerror=null;this.src='https://via.placeholder.com/400x240?text=Tanpa+Gambar';"
                                class="card-img-top"
                                style="height: 200px; object-fit: cover;"
                                alt="{{ $alat->nama_alat }}"
                            >
                            <div class="card-body">
                                <h5 class="card-title">{{ $alat->nama_alat }}</h5>
                                <p class="card-text mb-1"><strong>Kategori:</strong> {{ $alat->kategori }}</p>
                                <p class="card-text mb-1"><strong>Stok:</strong> {{ $alat->stok }} unit</p>
                                <p class="card-text mb-0"><strong>Lokasi:</strong> {{ $alat->lokasi }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-secondary mb-0">Belum ada alat laboratorium yang terdaftar.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
