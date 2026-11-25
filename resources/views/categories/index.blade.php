
@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div class="container-fluid px-4 px-lg-5 py-4">

    <x-page-header
        title="Kategori"
        subtitle="Kelola kategori pemasukan dan pengeluaranmu."
    >
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah kategori
        </a>
    </x-page-header>

    {{-- Expense categories --}}
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-1">Pengeluaran</h4>
                <p class="text-muted small mb-0">
                    Kategori untuk mencatat uang keluar.
                </p>
            </div>

            <span class="badge rounded-pill bg-danger-subtle text-danger">
                {{ $expenseCategories->count() }} kategori
            </span>
        </div>

        <div class="row g-3">
            @forelse ($expenseCategories as $category)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card category-card h-100">
                        <div class="card-body d-flex align-items-center gap-3">

                            <div class="category-icon expense-category-icon">
                                <i class="bi bi-arrow-down-left"></i>
                            </div>

                            <div class="flex-grow-1 min-width-0">
                                <h6 class="mb-1 text-truncate">
                                    {{ $category->name }}
                                </h6>

                                <span class="text-muted small">
                                    {{ $category->user_id === null ? 'Kategori default' : 'Kategori pribadi' }}
                                </span>
                            </div>

                            @if ($category->user_id !== null)
                                <div class="dropdown">
                                    <button
                                        class="btn btn-sm btn-light"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        aria-label="Opsi kategori"
                                    >
                                        <i class="bi bi-three-dots"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a
                                                class="dropdown-item"
                                                href="{{ route('categories.edit', $category) }}"
                                            >
                                                <i class="bi bi-pencil me-2"></i>
                                                Edit
                                            </a>
                                        </li>

                                        <li>
                                            <form
                                                action="{{ route('categories.destroy', $category) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="dropdown-item text-danger"
                                                >
                                                    <i class="bi bi-trash me-2"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <span class="badge bg-light text-muted">
                                    Default
                                </span>
                            @endif

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <x-empty-state
                        icon="bi-tags"
                        title="Belum ada kategori pengeluaran"
                        message="Tambahkan kategori untuk mengelompokkan pengeluaranmu."
                    />
                </div>
            @endforelse
        </div>
    </section>

    {{-- Income categories --}}
    <section>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-1">Pemasukan</h4>
                <p class="text-muted small mb-0">
                    Kategori untuk mencatat uang masuk.
                </p>
            </div>

            <span class="badge rounded-pill bg-success-subtle text-success">
                {{ $incomeCategories->count() }} kategori
            </span>
        </div>

        <div class="row g-3">
            @forelse ($incomeCategories as $category)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card category-card h-100">
                        <div class="card-body d-flex align-items-center gap-3">

                            <div class="category-icon income-category-icon">
                                <i class="bi bi-arrow-up-right"></i>
                            </div>

                            <div class="flex-grow-1 min-width-0">
                                <h6 class="mb-1 text-truncate">
                                    {{ $category->name }}
                                </h6>

                                <span class="text-muted small">
                                    {{ $category->user_id === null ? 'Kategori default' : 'Kategori pribadi' }}
                                </span>
                            </div>

                            @if ($category->user_id !== null)
                                <div class="dropdown">
                                    <button
                                        class="btn btn-sm btn-light"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        aria-label="Opsi kategori"
                                    >
                                        <i class="bi bi-three-dots"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a
                                                class="dropdown-item"
                                                href="{{ route('categories.edit', $category) }}"
                                            >
                                                <i class="bi bi-pencil me-2"></i>
                                                Edit
                                            </a>
                                        </li>

                                        <li>
                                            <form
                                                action="{{ route('categories.destroy', $category) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="dropdown-item text-danger"
                                                >
                                                    <i class="bi bi-trash me-2"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <span class="badge bg-light text-muted">
                                    Default
                                </span>
                            @endif

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <x-empty-state
                        icon="bi-tags"
                        title="Belum ada kategori pemasukan"
                        message="Tambahkan kategori untuk mengelompokkan pemasukanmu."
                    />
                </div>
            @endforelse
        </div>
    </section>

</div>
@endsection

