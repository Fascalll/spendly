<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
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

        $income = (clone $monthlyTransactions)
            ->where('type', 'income')
            ->sum('amount');

        $expense = (clone $monthlyTransactions)
            ->where('type', 'expense')
            ->sum('amount');

        $transactionCount = (clone $monthlyTransactions)
            ->count();

        $balance = $income - $expense;

        $recentTransactions = (clone $transactions)
            ->with('category')
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('dashboard', [
            'income' => $income,
            'expense' => $expense,
            'balance' => $balance,
            'transactionCount' => $transactionCount,
            'recentTransactions' => $recentTransactions,
            'currentMonth' => $currentMonth,
        ]);
    }
}
