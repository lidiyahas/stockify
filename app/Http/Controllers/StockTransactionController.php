<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\StockTransactionService;
use Illuminate\Support\Facades\Auth;

class StockTransactionController extends Controller
{
    private StockTransactionService $service;

    public function __construct(StockTransactionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $transactions = $this->service->getAll();
        return view('pages.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::all();
        return view('pages.transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:Masuk,Keluar',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:Pending,Diterima,Ditolak,Dikeluarkan',
            'notes' => 'nullable|string'
        ]);

        try {
            $this->service->create($validated, Auth::id());
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['quantity' => $e->getMessage()]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan');
    }

    public function edit(int $transaction)
    {
        try {
            $transaction = $this->service->getEditableTransaction($transaction);
        } catch (\Exception $e) {
            return redirect()->route('transactions.index')->with('error', $e->getMessage());
        }

        $products = Product::all();
        return view('pages.transactions.edit', compact('transaction', 'products'));
    }

    public function update(Request $request, int $transaction)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:Masuk,Keluar',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:Pending,Diterima,Ditolak,Dikeluarkan',
            'notes' => 'nullable|string'
        ]);

        try {
            $this->service->update($transaction, $validated);
        } catch (\Exception $e) {
            return redirect()->route('transactions.index')->with('error', $e->getMessage());
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }
}
