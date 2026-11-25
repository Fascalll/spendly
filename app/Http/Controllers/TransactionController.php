<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = $user->transactions()->with('category');

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->input('end_date'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where('description', 'like', "%{$search}%");
        }

        $transactions = $query
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $categories = Category::where(function ($query) use ($user) {
            $query->whereNull('user_id')
                ->orWhere('user_id', $user->id);
        })
            ->orderBy('name')
            ->get();

        return view('transactions.index', compact(
            'transactions',
            'categories'
        ));
    }

    public function create()
    {
        return view('transactions.form', [
            'transaction' => new Transaction,
            'categories' => $this->availableCategories(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateTransaction($request);

        auth()->user()->transactions()->create($validated);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $transaction = auth()->user()->transactions()->findOrFail($id);

        return view('transactions.form', [
            'transaction' => $transaction,
            'categories' => $this->availableCategories(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $transaction = auth()->user()->transactions()->findOrFail($id);

        $validated = $this->validateTransaction($request);

        $transaction->update($validated);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $transaction = auth()->user()->transactions()->findOrFail($id);

        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    private function validateTransaction(Request $request): array
    {
        return $request->validate([
            'type' => [
                'required',
                Rule::in(['income', 'expense']),
            ],

            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
                    ->where(function ($query) use ($request) {
                        $query->where('type', $request->input('type'))
                            ->where(function ($query) {
                                $query->whereNull('user_id')
                                    ->orWhere('user_id', auth()->id());
                            });
                    }),
            ],
            'amount' => [
                'required',
                'numeric',
                'decimal:0,2',
                'min:0.01',
                'max:9999999999999.99',
            ],
            'date' => [
                'required',
                'date',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'type.required' => 'Jenis transaksi wajib dipilih.',
            'type.in' => 'Jenis transaksi tidak valid.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'amount.required' => 'Nominal wajib diisi.',
            'amount.numeric' => 'Nominal harus berupa angka.',
            'amount.decimal' => 'Nominal maksimal memiliki 2 angka desimal.',
            'amount.min' => 'Nominal harus lebih dari 0.',
            'amount.max' => 'Nominal terlalu besar.',
            'date.required' => 'Tanggal transaksi wajib diisi.',
            'date.date' => 'Tanggal transaksi tidak valid.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ]);
    }

    private function availableCategories()
    {
        return Category::where(function ($query) {
            $query->whereNull('user_id')
                ->orWhere('user_id', auth()->id());
        })
            ->orderBy('type')
            ->orderBy('name')
            ->get();
    }
}
