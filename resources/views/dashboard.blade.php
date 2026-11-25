

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="h3 fw-bold mb-1">
                Halo, {{ auth()->user()->name }}!
            </h1>
            <p class="text-secondary mb-0">
                Selamat datang di Spendly.
            </p>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger">
                <i class="bi bi-box-arrow-right me-1"></i>
                Keluar
            </button>
        </form>
    </div>

    <x-alert type="success">
        {{ session('success') }}
    </x-alert>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h2 class="h5 fw-bold">Dashboard Spendly</h2>
            <p class="text-secondary mb-0">
                Tempat kamu memantau pemasukan dan pengeluaran.
                Fitur transaksi akan segera hadir!
            </p>
        </div>
    </div>

</div>
@endsection

