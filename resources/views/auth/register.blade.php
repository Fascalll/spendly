@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
<div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-md-8 col-lg-5 col-xl-4">

            <div class="text-center mb-4">
                <h1 class="fw-bold mb-1">Spendly<span class="text-primary">.</span></h1>
                <p class="text-secondary">Atur duit, biar nggak boncos.</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">

                    <h2 class="h4 fw-bold mb-2">Buat akun baru</h2>
                    <p class="text-secondary mb-4">
                        Mulai kelola keuanganmu dengan lebih mudah.
                    </p>

                    <x-alert type="success">
                        {{ session('success') }}
                    </x-alert>

                    <x-validation-errors />

                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Nama lengkap
                            </label>
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Nama kamu"
                                autocomplete="name"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                Email
                            </label>
                            <input
                                type="email"
                                class="form-control form-control-lg"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                autocomplete="email"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                Password
                            </label>
                            <input
                                type="password"
                                class="form-control form-control-lg"
                                id="password"
                                name="password"
                                placeholder="Minimal 8 karakter"
                                autocomplete="new-password"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                Konfirmasi password
                            </label>
                            <input
                                type="password"
                                class="form-control form-control-lg"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Ulangi password"
                                autocomplete="new-password"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold">
                            Buat akun
                        </button>
                    </form>

                    <p class="text-center text-secondary mt-4 mb-0">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">
                            Masuk
                        </a>
                    </p>

                </div>
            </div>

            <p class="text-center text-secondary small mt-4">
                &copy; {{ date('Y') }} Spendly. Kelola keuangan dengan lebih baik.
            </p>

        </div>
    </div>
</div>
@endsection

