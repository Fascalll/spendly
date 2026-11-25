
@extends('layouts.app')

@section('title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
<div class="container-fluid px-4 px-lg-5 py-4">

    <x-page-header
        :title="$category->exists ? 'Edit Kategori' : 'Tambah Kategori'"
        subtitle="Buat kategori agar transaksi lebih mudah dikelola."
    >
        <a href="{{ route('categories.index') }}" class="btn btn-light">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>
    </x-page-header>

    <div class="row">
        <div class="col-12 col-lg-7 col-xl-6">

            <div class="card category-form-card">
                <div class="card-body p-4">

                    <form
                        action="{{ $category->exists
                            ? route('categories.update', $category)
                            : route('categories.store') }}"
                        method="POST"
                    >
                        @csrf

                        @if ($category->exists)
                            @method('PUT')
                        @endif

                        {{-- Category name --}}
                        <div class="mb-4">
                            <label for="name" class="form-label">
                                Nama kategori
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}"
                                placeholder="Contoh: Belanja bulanan"
                                maxlength="100"
                                required
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Category type --}}
                        <div class="mb-4">
                            <label for="type" class="form-label">
                                Jenis kategori
                            </label>

                            <select
                                id="type"
                                name="type"
                                class="form-select @error('type') is-invalid @enderror"
                                required
                            >
                                <option value="">Pilih jenis kategori</option>

                                <option
                                    value="expense"
                                    {{ old('type', $category->type) === 'expense' ? 'selected' : '' }}
                                >
                                    Pengeluaran
                                </option>

                                <option
                                    value="income"
                                    {{ old('type', $category->type) === 'income' ? 'selected' : '' }}
                                >
                                    Pemasukan
                                </option>
                            </select>

                            @error('type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a
                                href="{{ route('categories.index') }}"
                                class="btn btn-light"
                            >
                                Batal
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>

                                {{ $category->exists ? 'Simpan perubahan' : 'Simpan kategori' }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection

