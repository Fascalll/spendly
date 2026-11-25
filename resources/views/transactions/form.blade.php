@extends('layouts.app')

@section('title', $transaction->exists ? 'Edit Transaksi' : 'Tambah Transaksi')

@section('content')
<div class="container-fluid px-4 px-lg-5 py-4">

    <x-page-header
        :title="$transaction->exists ? 'Edit Transaksi' : 'Tambah Transaksi'"
        subtitle="Catat uang masuk atau uang keluar."
    >
        <a href="{{ route('transactions.index') }}" class="btn btn-light">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>
    </x-page-header>

    <div class="row">
        <div class="col-12 col-lg-8 col-xl-7">

            <div class="card transaction-form-card">
                <div class="card-body p-4">

                    <form
                        action="{{ $transaction->exists
                            ? route('transactions.update', $transaction)
                            : route('transactions.store') }}"
                        method="POST"
                    >
                        @csrf

                        @if ($transaction->exists)
                            @method('PUT')
                        @endif

                        {{-- Type --}}
                        <div class="mb-4">

                            <label class="form-label">
                                Jenis transaksi
                            </label>

                            <div class="transaction-type-selector">

                                <label class="transaction-type-option income-option">
                                    <input
                                        type="radio"
                                        name="type"
                                        value="income"
                                        {{ old('type', $transaction->type) === 'income' ? 'checked' : '' }}
                                        required
                                    >

                                    <span>
                                        <i class="bi bi-arrow-up-right"></i>
                                        Pemasukan
                                    </span>
                                </label>

                                <label class="transaction-type-option expense-option">
                                    <input
                                        type="radio"
                                        name="type"
                                        value="expense"
                                        {{ old('type', $transaction->type ?: 'expense') === 'expense' ? 'checked' : '' }}
                                        required
                                    >

                                    <span>
                                        <i class="bi bi-arrow-down-left"></i>
                                        Pengeluaran
                                    </span>
                                </label>

                            </div>

                            @error('type')
                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Amount --}}
                        <div class="mb-4">

                            <label for="amount" class="form-label">
                                Nominal
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">Rp</span>

                                <input
                                    type="number"
                                    name="amount"
                                    id="amount"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount', $transaction->amount) }}"
                                    placeholder="0"
                                    min="0.01"
                                    step="0.01"
                                    max="9999999999999.99"
                                    required
                                >

                                @error('amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-text">
                                Masukkan nominal transaksi dalam Rupiah.
                            </div>

                        </div>

                        {{-- Category --}}
                        <div class="mb-4">

                            <label for="category_id" class="form-label">
                                Kategori
                            </label>

                            <select
                                name="category_id"
                                id="category_id"
                                class="form-select @error('category_id') is-invalid @enderror"
                                required
                            >
                                <option value="">Pilih kategori</option>

                                @foreach ($categories as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        data-category-type="{{ $category->type }}"
                                        {{ (string) old('category_id', $transaction->category_id) === (string) $category->id ? 'selected' : '' }}
                                    >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Date --}}
                        <div class="mb-4">

                            <label for="date" class="form-label">
                                Tanggal transaksi
                            </label>

                            <input
                                type="date"
                                name="date"
                                id="date"
                                class="form-control @error('date') is-invalid @enderror"
                                value="{{ old('date', $transaction->date?->format('Y-m-d') ?? now()->toDateString()) }}"
                                required
                            >

                            @error('date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Description --}}
                        <div class="mb-4">

                            <label for="description" class="form-label">
                                Deskripsi <span class="text-muted">(opsional)</span>
                            </label>

                            <textarea
                                name="description"
                                id="description"
                                rows="3"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Contoh: makan siang, beli kopi, gaji bulanan..."
                            >{{ old('description', $transaction->description) }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="{{ route('transactions.index') }}"
                                class="btn btn-light"
                            >
                                Batal
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>

                                {{ $transaction->exists ? 'Simpan perubahan' : 'Simpan transaksi' }}
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeInputs = document.querySelectorAll('input[name="type"]');
    const categorySelect = document.getElementById('category_id');

    function updateCategories() {
        const selectedType = document.querySelector('input[name="type"]:checked')?.value;

        Array.from(categorySelect.options).forEach(function (option) {
            if (!option.value) {
                option.hidden = false;
                return;
            }

            const matches = option.dataset.categoryType === selectedType;

            option.hidden = !matches;
        });

        const selectedOption = categorySelect.selectedOptions[0];

        if (
            selectedOption &&
            selectedOption.value &&
            selectedOption.dataset.categoryType !== selectedType
        ) {
            categorySelect.value = '';
        }
    }

    typeInputs.forEach(function (input) {
        input.addEventListener('change', updateCategories);
    });

    updateCategories();
});
</script>
@endpush
