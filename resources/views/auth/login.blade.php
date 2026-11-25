@extends('layouts.app')

@section('title', 'Masuk')

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

                    <h2 class="h4 fw-bold mb-2">Selamat datang kembali!</h2>
                    <p class="text-secondary mb-4">
                        Masuk ke akun Spendly kamu.
                    </p>

                    <x-alert type="success">
                        {{ session('success') }}
                    </x-alert>

                    <x-validation-errors />

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

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

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">
                                Password
                            </label>
                            <input
                                type="password"
                                class="form-control form-control-lg"
                                id="password"
                                name="password"
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold">
                            Masuk
                        </button>
                    </form>

                    <p class="text-center text-secondary mt-4 mb-0">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">
                            Daftar sekarang
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
