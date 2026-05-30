<x-guest-layout>

<div class="card border-0 shadow-lg rounded-4">
    <div class="card-body p-5">

```
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">
            Registrasi Mahasiswa
        </h2>
        <p class="text-muted">
            Buat akun untuk melakukan peminjaman alat laboratorium
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">
                Nama Lengkap
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="form-control"
                placeholder="Masukkan nama lengkap"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">
                Email
            </label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="form-control"
                placeholder="Masukkan email"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">
                NIM Mahasiswa
            </label>

            <input
                type="text"
                name="nim"
                value="{{ old('nim') }}"
                class="form-control"
                placeholder="Masukkan NIM"
                required>

            <small class="text-muted">
                Hanya mahasiswa yang dapat melakukan registrasi.
            </small>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">
                Password
            </label>

            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Masukkan password"
                required>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">
                Konfirmasi Password
            </label>

            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                placeholder="Ulangi password"
                required>
        </div>

        <button
            type="submit"
            class="btn btn-primary w-100">
            Daftar
        </button>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}"
               class="text-decoration-none">
                Sudah punya akun? Login di sini
            </a>
        </div>

    </form>

</div>
```

</div>

</x-guest-layout>
