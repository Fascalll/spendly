@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="container-fluid px-4 px-lg-5 py-4">

    <x-page-header
        title="Transaksi"
        subtitle="Catat dan pantau pemasukan serta pengeluaranmu."
    >
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah transaksi
        </a>
    </x-page-header>

    {{-- Filters --}}
    <div class="card transaction-filter-card mb-4">
        <div class="card-body">

            <form action="{{ route('transactions.index') }}" method="GET">

                <div class="row g-3 align-items-end">

                    <div class="col-12 col-md-6 col-xl-3">
                        <label for="search" class="form-label">
                            Cari deskripsi
                        </label>

                        <input
                            type="text"
                            name="search"
                            id="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="Contoh: Kopi, Gojek..."
                        >
                    </div>

                    <div class="col-12 col-md-6 col-xl-2">
                        <label for="type" class="form-label">
                            Jenis
                        </label>

                        <select name="type" id="type" class="form-select">
                            <option value="">Semua jenis</option>
                            <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>
                                Pemasukan
                            </option>
                            <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>
                                Pengeluaran
                            </option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-xl-3">
                        <label for="category_id" class="form-label">
                            Kategori
                        </label>

                        <select
                            name="category_id"
                            id="category_id"
                            class="form-select"
                        >
                            <option value="">Semua kategori</option>

                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                    ({{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-xl-2">
                        <label for="start_date" class="form-label">
                            Dari tanggal
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            id="start_date"
                            class="form-control"
                            value="{{ request('start_date') }}"
                        >
                    </div>

                    <div class="col-12 col-md-6 col-xl-2">
                        <label for="end_date" class="form-label">
                            Sampai
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            id="end_date"
                            class="form-control"
                            value="{{ request('end_date') }}"
                        >
                    </div>

                    <div class="col-12 d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel me-1"></i>
                            Filter
                        </button>

                        <a
                            href="{{ route('transactions.index') }}"
                            class="btn btn-light"
                        >
                            Reset
                        </a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    {{-- Transaction history --}}
    <div class="card transaction-list-card">

        <div class="card-body p-0">

            @if ($transactions->count() > 0)

                {{-- Desktop table --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table transaction-table align-middle mb-0">

                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Kategori</th>
                                <th>Jenis</th>
                                <th class="text-end">Nominal</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="text-nowrap">
                                        {{ $transaction->date->format('d/m/Y') }}
                                    </td>

                                    <td>
                                        <div class="transaction-description">
                                            {{ $transaction->description ?: 'Tanpa deskripsi' }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="category-pill">
                                            {{ $transaction->category->name }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($transaction->type === 'income')
                                            <span class="transaction-type income-type">
                                                <i class="bi bi-arrow-up-right"></i>
                                                Pemasukan
                                            </span>
                                        @else
                                            <span class="transaction-type expense-type">
                                                <i class="bi bi-arrow-down-left"></i>
                                                Pengeluaran
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-end text-nowrap">
                                        <span class="{{ $transaction->type === 'income' ? 'amount-income' : 'amount-expense' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format((float) $transaction->amount, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">

                                            <a
                                                href="{{ route('transactions.edit', $transaction) }}"
                                                class="btn btn-sm btn-light"
                                                aria-label="Edit transaksi"
                                                title="Edit"
                                            >
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form
                                                action="{{ route('transactions.destroy', $transaction) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-light text-danger"
                                                    aria-label="Hapus transaksi"
                                                    title="Hapus"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                {{-- Mobile list --}}
                <div class="transaction-mobile-list d-md-none">

                    @foreach ($transactions as $transaction)
                        <div class="transaction-mobile-item">

                            <div class="d-flex align-items-start gap-3">

                                <div class="transaction-mobile-icon {{ $transaction->type === 'income' ? 'income-category-icon' : 'expense-category-icon' }}">
                                    <i class="bi {{ $transaction->type === 'income' ? 'bi-arrow-up-right' : 'bi-arrow-down-left' }}"></i>
                                </div>

                                <div class="flex-grow-1 min-width-0">

                                    <div class="d-flex justify-content-between gap-2">
                                        <h6 class="mb-1 text-break">
                                            {{ $transaction->description ?: 'Tanpa deskripsi' }}
                                        </h6>

                                        <span class="text-nowrap {{ $transaction->type === 'income' ? 'amount-income' : 'amount-expense' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format((float) $transaction->amount, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="text-muted small mb-2">
                                        {{ $transaction->category->name }}
                                        &middot;
                                        {{ $transaction->date->format('d/m/Y') }}
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">

                                        <span class="transaction-type {{ $transaction->type === 'income' ? 'income-type' : 'expense-type' }}">
                                            {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                        </span>

                                        <div class="d-flex gap-2">

                                            <a
                                                href="{{ route('transactions.edit', $transaction) }}"
                                                class="btn btn-sm btn-light"
                                            >
                                                <i class="bi bi-pencil"></i>
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('transactions.destroy', $transaction) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-light text-danger"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            @else

                <div class="p-4 p-lg-5">
                    <x-empty-state
                        icon="bi-receipt"
                        title="Belum ada transaksi"
                        message="Transaksi tidak ditemukan. Coba ubah filter atau tambahkan transaksi baru."
                    >
                        <a
                            href="{{ route('transactions.create') }}"
                            class="btn btn-primary mt-3"
                        >
                            <i class="bi bi-plus-lg me-1"></i>
                            Tambah transaksi
                        </a>
                    </x-empty-state>
                </div>

            @endif

        </div>

        {{-- Pagination --}}
        @if ($transactions->hasPages())
            <div class="card-footer bg-white border-top-0 px-3 px-lg-4 py-3">
                {{ $transactions->links() }}
            </div>
        @endif

    </div>

    <div class="text-muted small mt-3">
        Menampilkan {{ $transactions->count() }} dari {{ $transactions->total() }} transaksi.
    </div>

</div>
@endsection
