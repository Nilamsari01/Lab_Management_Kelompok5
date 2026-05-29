# Lab Management Kelompok 5

Aplikasi web **Lab_Management** untuk pengelolaan peminjaman alat laboratorium di institusi pendidikan.

## Fitur Utama

- Pencatatan permohonan peminjaman alat oleh mahasiswa.
- Validasi permohonan oleh petugas/dosen melalui dashboard.
- Monitoring stok alat dan lokasi rak secara real-time.
- Unggah bukti dokumen atau foto saat mengajukan peminjaman.
- REST API untuk `alat`, `kategori`, dan `peminjaman`.
- SOAP service untuk dukungan interoperabilitas enterprise.

## Alur Peminjaman Mahasiswa

1. Mahasiswa membuka halaman `Peminjaman` dan memilih alat yang diperlukan.
2. Mahasiswa memasukkan jumlah setiap alat dan mengunggah bukti permohonan.
3. Permohonan disimpan dengan status `pending`.
4. Petugas/dosen dapat membuka menu `Approval` untuk menerima atau menolak.
5. Setelah disetujui, mahasiswa dapat mengembalikan alat. Status peminjaman diperbarui menjadi `kembali`.

## REST API

### API Alat

- `GET /api/alat` - daftar semua alat.
- `GET /api/alat/{id}` - detail alat.
- `POST /api/alat` - tambah alat baru.
  - Body JSON: `nama_alat`, `kategori`, `stok`, `lokasi`.
- `PUT/PATCH /api/alat/{id}` - perbarui data alat.
- `DELETE /api/alat/{id}` - hapus alat.

### API Kategori

- `GET /api/kategori` - daftar kategori.
- `GET /api/kategori/{id}` - detail kategori.
- `POST /api/kategori` - tambah kategori.
  - Body JSON: `nama`.
- `PUT/PATCH /api/kategori/{id}` - perbarui kategori.
- `DELETE /api/kategori/{id}` - hapus kategori.

### API Peminjaman

- `GET /api/peminjaman` - daftar semua peminjaman.
  - Query opsional: `?status=pending`, `?status=disetujui`, `?status=ditolak`, `?status=kembali`.
- `GET /api/peminjaman/{id}` - detail permohonan.
- `POST /api/peminjaman` - buat permohonan baru.
  - Contoh body JSON multi-item:

```json
{
  "user_id": 1,
  "tanggal_pinjam": "2026-05-29",
  "status": "pending",
  "details": [
    { "alat_id": 2, "jumlah": 1 },
    { "alat_id": 3, "jumlah": 2 }
  ]
}
```

  - Contoh body JSON sederhana:

```json
{
  "user_id": 1,
  "alat_id": 2,
  "jumlah_pinjam": 1,
  "tanggal_pinjam": "2026-05-29",
  "status": "pending"
}
```

  - Dukungan unggah file bukti menggunakan `multipart/form-data`.
- `PUT/PATCH /api/peminjaman/{id}` - perbarui status, detail, atau bukti peminjaman.
- `DELETE /api/peminjaman/{id}` - hapus permohonan.

## SOAP Service

Endpoint: `POST /soap-service`

Metode SOAP yang tersedia:

- `getStokAlat(string $namaAlat)`
  - Mengembalikan informasi stok dan lokasi alat.
- `listAlat()`
  - Mengembalikan daftar alat laboratorium.
- `getPeminjamanStatusByUser(int $userId)`
  - Menampilkan status riwayat peminjaman untuk pengguna.
- `getPeminjamanById(int $id)`
  - Menampilkan detail permohonan peminjaman.

> SOAP service menggunakan mode non-WSDL agar dapat diakses melalui permintaan SOAP langsung.

## Contoh Permintaan SOAP

Contoh `curl` SOAP:

```bash
curl -X POST \
  -H "Content-Type: text/xml" \
  --data @request.xml \
  http://127.0.0.1:8000/soap-service
```
