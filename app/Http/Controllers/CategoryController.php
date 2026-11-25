<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where(function ($query) {
            $query->whereNull('user_id')
                ->orWhere('user_id', auth()->id());
        })
            ->orderBy('name')
            ->get();

        return view('categories.index', [
            'expenseCategories' => $categories->where('type', 'expense'),
            'incomeCategories' => $categories->where('type', 'income'),
        ]);
    }

    public function create()
    {
        return view('categories.form', [
            'category' => new Category(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'type' => [
                'required',
                Rule::in(['income', 'expense']),
            ],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
            'type.required' => 'Jenis kategori wajib dipilih.',
            'type.in' => 'Jenis kategori tidak valid.',
        ]);

        $duplicate = auth()->user()->categories()
            ->where('name', $validated['name'])
            ->where('type', $validated['type'])
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'Kategori dengan nama dan jenis ini sudah ada.',
                ]);
        }

        auth()->user()->categories()->create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        $this->authorizeCategory($category);

        return view('categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeCategory($category);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'type' => [
                'required',
                Rule::in(['income', 'expense']),
            ],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
            'type.required' => 'Jenis kategori wajib dipilih.',
            'type.in' => 'Jenis kategori tidak valid.',
        ]);

        $duplicate = auth()->user()->categories()
            ->where('name', $validated['name'])
            ->where('type', $validated['type'])
            ->where('id', '!=', $category->id)
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'Kategori dengan nama dan jenis ini sudah ada.',
                ]);
        }

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $this->authorizeCategory($category);

        if ($category->transactions()->exists()) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh transaksi.');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    private function authorizeCategory(Category $category): void
    {
        abort_unless(
            $category->user_id === auth()->id(),
            403,
            'Anda tidak memiliki akses ke kategori ini.'
        );
    }
}

