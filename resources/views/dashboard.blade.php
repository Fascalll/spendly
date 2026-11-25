@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4 px-lg-5 py-4 py-lg-5">

    <x-page-header title="Dashboard" subtitle="Pantau arus keuanganmu, biar nggak boncos." />

    {{-- Month filter --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <span class="text-muted small">Ringkasan keuangan</span>
            <h5 class="mb-0 mt-1">
                {{ $currentMonth->translatedFormat('F Y') }}
            </h5>
        </div>

        <form action="{{ route('dashboard') }}" method="GET" class="d-flex gap-2">
            <input type="month" name="month" value="{{ $currentMonth->format('Y-m') }}" class="form-control"
                aria-label="Pilih bulan">

            <button class="btn btn-primary px-3" type="submit">
                <i class="bi bi-filter me-1"></i>
                Filter
            </button>
        </form>
    </div>

    {{-- Financial summary --}}
    <div class="row g-3 g-lg-4 mb-4">

        {{-- Balance --}}
        <div class="col-12 col-md-6 col-xl-3">
            <div class="dashboard-card dashboard-card-balance h-100">
                <div class="dashboard-card-top">
                    <span class="dashboard-card-label">Saldo bulan ini</span>
                    <span class="dashboard-icon dashboard-icon-balance">
                        <i class="bi bi-wallet2"></i>
                    </span>
                </div>

                <h3 class="dashboard-card-amount">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </h3>

                <p class="dashboard-card-description mb-0">
                    Selisih pemasukan dan pengeluaran
                </p>
            </div>
        </div>

        {{-- Income --}}
        <div class="col-12 col-md-6 col-xl-3">
            <div class="dashboard-card h-100">
                <div class="dashboard-card-top">
                    <span class="dashboard-card-label">Pemasukan</span>
                    <span class="dashboard-icon dashboard-icon-income">
                        <i class="bi bi-arrow-down-left"></i>
                    </span>
                </div>

                <h3 class="dashboard-card-amount text-income">
                    Rp {{ number_format($income, 0, ',', '.') }}
                </h3>

                <p class="dashboard-card-description mb-0">
                    Total uang masuk bulan ini
                </p>
            </div>
        </div>

        {{-- Expense --}}
        <div class="col-12 col-md-6 col-xl-3">
            <div class="dashboard-card h-100">
                <div class="dashboard-card-top">
                    <span class="dashboard-card-label">Pengeluaran</span>
                    <span class="dashboard-icon dashboard-icon-expense">
                        <i class="bi bi-arrow-up-right"></i>
                    </span>
                </div>

                <h3 class="dashboard-card-amount text-expense">
                    Rp {{ number_format($expense, 0, ',', '.') }}
                </h3>

                <p class="dashboard-card-description mb-0">
                    Total uang keluar bulan ini
                </p>
            </div>
        </div>

        {{-- Transactions --}}
        <div class="col-12 col-md-6 col-xl-3">
            <div class="dashboard-card h-100">
                <div class="dashboard-card-top">
                    <span class="dashboard-card-label">Transaksi</span>
                    <span class="dashboard-icon dashboard-icon-transactions">
                        <i class="bi bi-receipt"></i>
                    </span>
                </div>

                <h3 class="dashboard-card-amount">
                    {{ number_format($transactionCount, 0, ',', '.') }}
                </h3>

                <p class="dashboard-card-description mb-0">
                    Transaksi bulan ini
                </p>
            </div>
        </div>

    </div>

    {{-- Dashboard charts --}}
    <div class="row g-3 g-lg-4 mb-4">

        {{-- Income vs Expense --}}
        <div class="col-12 col-lg-5">
            <div class="card dashboard-section-card h-100 p-4">
                <div class="mb-3">
                    <h5 class="mb-1">Pemasukan vs Pengeluaran</h5>
                    <p class="text-muted small mb-0">
                        Perbandingan keuangan bulan ini
                    </p>
                </div>

                <div class="dashboard-chart-container dashboard-chart-bar">
                    <canvas id="incomeExpenseChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Expense by category --}}
        <div class="col-12 col-lg-7">
            <div class="card dashboard-section-card h-100 p-4">
                <div class="mb-3">
                    <h5 class="mb-1">Pengeluaran berdasarkan kategori</h5>
                    <p class="text-muted small mb-0">
                        Distribusi pengeluaran bulan ini
                    </p>
                </div>

                @if ($expenseCategoryChart->isEmpty())
                    <x-empty-state
                        icon="bi-pie-chart"
                        title="Belum ada pengeluaran"
                        message="Pengeluaran berdasarkan kategori akan muncul di sini."
                    />
                @else
                    <div class="dashboard-chart-container dashboard-chart-doughnut">
                        <canvas id="expenseCategoryChart"></canvas>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- Currency Exchange Widget --}}
    <div class="card currency-card h-100">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h5 class="mb-1">Kurs Mata Uang</h5>
                    <p class="text-muted small mb-0">
                        Referensi dari IDR
                    </p>
                </div>

                <div class="currency-icon">
                    <i class="bi bi-currency-exchange"></i>
                </div>
            </div>

            @if (!empty($currencyRates['rates']))

                <div class="currency-list">

                    @php
                        $currencySymbols = [
                            'USD' => '$',
                            'EUR' => '€',
                            'JPY' => '¥',
                            'SGD' => 'S$',
                            'GBP' => '£',
                        ];

                        $currencyNames = [
                            'USD' => 'US Dollar',
                            'EUR' => 'Euro',
                            'JPY' => 'Japanese Yen',
                            'SGD' => 'Singapore Dollar',
                            'GBP' => 'British Pound',
                        ];
                    @endphp

                    @foreach ($currencyRates['rates'] as $code => $rate)

                        <div class="currency-item">

                            <div class="currency-info">
                                <div class="currency-code">
                                    {{ $code }}
                                </div>

                                <div class="currency-name">
                                    {{ $currencyNames[$code] ?? $code }}
                                </div>
                            </div>

                            <div class="currency-value">
                                {{ $currencySymbols[$code] ?? '' }}
                                {{ number_format(1000000 * $rate, 2, ',', '.') }}
                            </div>

                        </div>

                    @endforeach

                </div>

                @if ($currencyRates['date'])
                    <p class="text-muted small mt-3 mb-0">
                        <i class="bi bi-clock me-1"></i>
                        Data per
                        {{ \Carbon\Carbon::parse($currencyRates['date'])->format('d M Y') }}
                    </p>
                @endif

            @else

                <div class="text-center py-4">
                    <i class="bi bi-cloud-slash fs-2 text-muted"></i>

                    <p class="text-muted small mt-2 mb-0">
                        Kurs mata uang sementara tidak tersedia.
                    </p>
                </div>

            @endif

            <div class="currency-disclaimer mt-4">
                <i class="bi bi-info-circle me-1"></i>
                Nilai di atas merupakan referensi untuk
                Rp1.000.000, bukan kurs transaksi aktual.
            </div>

        </div>

    </div>

    {{-- Recent transactions --}}
    <div class="card dashboard-section-card border-0 rounded-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-4">
            <div>
                <h5 class="mb-1">Transaksi terbaru</h5>
                <p class="text-muted small mb-0">
                    Aktivitas keuangan terakhir
                </p>
            </div>

            <a href="#" class="btn btn-sm btn-outline-primary rounded-3">
                <span>Lihat semua</span>
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table dashboard-table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Transaksi</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th class="text-end pe-4">Jumlah</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($recentTransactions as $transaction)
                    <tr>
                        <td class="ps-4">
                            <div class="transaction-name">
                                {{ $transaction->description ?: 'Transaksi' }}
                            </div>
                        </td>

                        <td>
                            <span class="category-badge">
                                {{ $transaction->category->name ?? 'Tanpa kategori' }}
                            </span>
                        </td>

                        <td>
                            <span class="text-muted small">
                                {{ \Illuminate\Support\Carbon::parse($transaction->date)->translatedFormat('d M Y') }}
                            </span>
                        </td>

                        <td class="text-end pe-4">
                            <span
                                class="fw-semibold {{ $transaction->type === 'income' ? 'text-income' : 'text-expense' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-0">
                            <x-empty-state icon="bi-wallet2" title="Belum ada transaksi"
                                message="Transaksi yang kamu catat akan muncul di sini." />
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const Chart = window.Chart;

        if (!Chart) return;

        // Income vs Expense Chart
        const incomeExpenseCanvas = document.getElementById('incomeExpenseChart');

        if (incomeExpenseCanvas) {
            new Chart(incomeExpenseCanvas, {
                type: 'bar',
                data: {
                    labels: ['Pemasukan', 'Pengeluaran'],
                    datasets: [{
                        label: 'Jumlah (Rp)',
                        data: [
                            {{ $incomeExpenseChart['income'] }},
                            {{ $incomeExpenseChart['expense'] }}
                        ],
                        backgroundColor: [
                            '#16A36A',
                            '#E65C5C'
                        ],
                        borderRadius: 8,
                        borderSkipped: false,
                        maxBarThickness: 70
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID', {
                                        notation: 'compact'
                                    }).format(value);
                                }
                            },
                            grid: {
                                color: '#E8EAF0'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        // Expense by Category Chart
        const expenseCategoryCanvas = document.getElementById('expenseCategoryChart');

        if (expenseCategoryCanvas) {
            new Chart(expenseCategoryCanvas, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($expenseCategoryChart->keys()->values()) !!},
                    datasets: [{
                        data: {!! json_encode($expenseCategoryChart->values()->values()) !!},
                        backgroundColor: [
                            '#536DFE',
                            '#16A36A',
                            '#E65C5C',
                            '#F4B740',
                            '#8B5CF6',
                            '#14B8A6',
                            '#F97316',
                            '#64748B',
                            '#EC4899'
                        ],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 16,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const amount = new Intl.NumberFormat('id-ID').format(context.raw);

                                    return label + ': Rp ' + amount;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
