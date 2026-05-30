<x-guest-layout>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">

```
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">

                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">
                        Sistem Informasi Laboratorium
                    </h2>
                    <p class="text-muted">
                        Silakan masuk ke akun Anda
                    </p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control form-control-lg"
                            placeholder="Masukkan email"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control form-control-lg"
                            placeholder="Masukkan password"
                            required>
                    </div>

                    <div class="form-check mb-4">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            name="remember"
                            id="remember">

                        <label
                            class="form-check-label"
                            for="remember">
                            Remember Me
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary btn-lg w-100">
                        Login
                    </button>

                    @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a href="{{ route('password.request') }}"
                               class="text-decoration-none">
                                Lupa Password?
                            </a>
                        </div>
                    @endif

                </form>

            </div>
        </div>

    </div>
</div>
```

</div>

</x-guest-layout>
