<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockTransaction;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class StockTransactionController extends Controller
{
    public function index()
    {
        $transactions = StockTransaction::with(['product', 'user'])->latest()->get();
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

        $product = Product::findOrFail($validated['product_id']);

        // Hitung stok tersedia dari transaksi yang sudah final (bukan Pending/Ditolak)
        $totalMasuk = StockTransaction::where('product_id', $product->id)
            ->where('type', 'Masuk')
            ->where('status', 'Diterima')
            ->sum('quantity');

        $totalKeluar = StockTransaction::where('product_id', $product->id)
            ->where('type', 'Keluar')
            ->where('status', 'Dikeluarkan')
            ->sum('quantity');

        $stokTersedia = $totalMasuk - $totalKeluar;

        // Kalau tipe Keluar dan jumlahnya melebihi stok tersedia -> tolak, JANGAN disimpan
        if ($validated['type'] === 'Keluar' && $validated['quantity'] > $stokTersedia) {
            return back()
                ->withInput()
                ->withErrors([
                    'quantity' => "Stok tidak mencukupi. Stok yang tersedia hanya {$stokTersedia}."
                ]);
        }

        $validated['user_id'] = Auth::id();
        $validated['date'] = now();

        // Simpan transaksi HANYA jika sudah lolos validasi di atas
        StockTransaction::create($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan');
    }

    public function edit(StockTransaction $transaction)
    {
        // Hanya transaksi berstatus Pending yang boleh diedit
        if ($transaction->status !== 'Pending') {
            return redirect()->route('transactions.index')
                ->with('error', 'Transaksi yang sudah diproses tidak bisa diedit.');
        }

        $products = Product::all();
        return view('pages.transactions.edit', compact('transaction', 'products'));
    }

    public function update(Request $request, StockTransaction $transaction)
    {
        // Cek ulang di backend, jangan andalkan tampilan saja
        if ($transaction->status !== 'Pending') {
            return redirect()->route('transactions.index')
                ->with('error', 'Transaksi yang sudah diproses tidak bisa diedit.');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:Masuk,Keluar',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:Pending,Diterima,Ditolak,Dikeluarkan',
            'notes' => 'nullable|string'
        ]);

        // Kalau jenisnya Keluar dan status diubah jadi Dikeluarkan, cek stok tersedia
        if ($validated['type'] === 'Keluar' && $validated['status'] === 'Dikeluarkan') {
            $totalMasuk = StockTransaction::where('product_id', $validated['product_id'])
                ->where('type', 'Masuk')
                ->where('status', 'Diterima')
                ->sum('quantity');

            $totalKeluar = StockTransaction::where('product_id', $validated['product_id'])
                ->where('type', 'Keluar')
                ->where('status', 'Dikeluarkan')
                ->where('id', '!=', $transaction->id)
                ->sum('quantity');

            $stokTersedia = $totalMasuk - $totalKeluar;

            if ($validated['quantity'] > $stokTersedia) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'quantity' => "Stok tidak mencukupi. Stok yang tersedia hanya {$stokTersedia}."
                    ]);
            }
        }

        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }
}