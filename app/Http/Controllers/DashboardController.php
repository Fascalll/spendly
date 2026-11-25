<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\CurrencyService;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $currencyRates = app(CurrencyService::class)->getRates();
        $selectedMonth = $request->query('month');

        try {
            $currentMonth = $selectedMonth
                ? Carbon::createFromFormat('Y-m', $selectedMonth)
                : Carbon::now();
        } catch (\Exception $e) {
            $currentMonth = Carbon::now();
        }

        if (
            $selectedMonth &&
            $currentMonth->format('Y-m') !== $selectedMonth
        ) {
            $currentMonth = Carbon::now();
        }

        $startOfMonth = $currentMonth->copy()->startOfMonth();
        $endOfMonth = $currentMonth->copy()->endOfMonth();

        $transactions = Transaction::where('user_id', auth()->id());

        $monthlyTransactions = (clone $transactions)
            ->whereBetween('date', [
                $startOfMonth->toDateString(),
                $endOfMonth->toDateString(),
            ]);

        // Monthly income
        $income = (clone $monthlyTransactions)
            ->where('type', 'income')
            ->sum('amount');

        // Monthly expense
        $expense = (clone $monthlyTransactions)
            ->where('type', 'expense')
            ->sum('amount');

        // Monthly transaction count
        $transactionCount = (clone $monthlyTransactions)
            ->count();

        // Monthly balance
        $balance = $income - $expense;

        // Recent transactions: latest 5 across all months
        $recentTransactions = (clone $transactions)
            ->with('category')
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Monthly expenses grouped by category for the chart
        $expenseByCategory = (clone $monthlyTransactions)
            ->where('type', 'expense')
            ->with('category')
            ->get()
            ->groupBy(fn ($transaction) => $transaction->category->name ?? 'Tanpa kategori')
            ->map(fn ($group) => $group->sum('amount'));

        return view('dashboard', [
            'income' => $income,
            'expense' => $expense,
            'balance' => $balance,
            'transactionCount' => $transactionCount,
            'recentTransactions' => $recentTransactions,
            'currentMonth' => $currentMonth,
            'currencyRates' => $currencyRates,
            // Chart data
            'incomeExpenseChart' => [
                'income' => $income,
                'expense' => $expense,
            ],

            'expenseCategoryChart' => $expenseByCategory,
        ]);
    }
}

