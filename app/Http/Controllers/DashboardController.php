<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $startDate = Carbon::now()->subDays(30);

        // Data umum yang bisa diakses oleh admin & manajer
        $grafikStok = Product::with(['transactions' => function ($q) {
                // status wajib ikut di-select, karena dipakai untuk filter
                $q->select('product_id', 'type', 'quantity', 'status');
            }])->get()
            ->map(function ($product) {
                $stok = $product->transactions
                    ->reduce(function ($carry, $trx) {
                        // Hanya transaksi yang statusnya SUDAH FINAL yang dihitung
                        if ($trx->type === 'Masuk' && $trx->status === 'Diterima') {
                            return $carry + $trx->quantity;
                        }
                        if ($trx->type === 'Keluar' && $trx->status === 'Dikeluarkan') {
                            return $carry - $trx->quantity;
                        }
                        // Pending & Ditolak diabaikan, tidak mempengaruhi stok
                        return $carry;
                    }, 0);
                return [
                    'name' => $product->name,
                    'stock' => $stok,
                    'minimum_stock' => $product->minimum_stock,
                ];
            })
            ->filter(function ($item) {
                // Hanya tampilkan produk yang stoknya di bawah batas minimum
                return $item['stock'] < $item['minimum_stock'];
            })
            ->sortBy('stock')
            ->values();

        $transaksiMasuk = StockTransaction::where('type', 'Masuk')
            ->where('created_at', '>=', $startDate)
            ->count();

        $transaksiKeluar = StockTransaction::where('type', 'Keluar')
            ->where('created_at', '>=', $startDate)
            ->count();

        // Data khusus admin
        $jumlahProduk = null;
        $aktivitasPengguna = collect();

        if ($role === 'admin') {
            $jumlahProduk = Product::count();

            $aktivitasPengguna = User::orderBy('updated_at', 'desc')
                ->take(5)
                ->get();
        }

        // Data khusus staff_gudang: jobdesk transaksi pending
        $barangMasukPending = collect();
        $barangKeluarPending = collect();

        if ($role === 'staff_gudang') {
            $barangMasukPending = StockTransaction::with('product')
                ->where('type', 'Masuk')
                ->where('status', 'Pending')
                ->latest()
                ->get();

            $barangKeluarPending = StockTransaction::with('product')
                ->where('type', 'Keluar')
                ->where('status', 'Pending')
                ->latest()
                ->get();
        }

        return view('pages.dashboard.admin', compact(
            'jumlahProduk',
            'transaksiMasuk',
            'transaksiKeluar',
            'grafikStok',
            'aktivitasPengguna',
            'barangMasukPending',
            'barangKeluarPending',
            'role'
        ));
    }
}