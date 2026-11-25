@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid px-4 px-lg-5 py-4 py-lg-5">

        <x-page-header
            title="Dashboard"
            subtitle="Ringkasan keuanganmu hari ini."
        />

        <div class="card border-0 rounded-4 p-4">
            <x-empty-state
                icon="bi-wallet2"
                title="Keuanganmu dimulai di sini"
                message="Belum ada transaksi yang tercatat. Yuk, mulai catat pemasukan dan pengeluaranmu agar keuangan lebih teratur."
            >
                <button type="button" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>
                    Tambah transaksi
                </button>
            </x-empty-state>
        </div>

    </div>
@endsection
