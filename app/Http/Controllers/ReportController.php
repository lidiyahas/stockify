<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\StockTransaction;
use App\Models\User;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        $aktivitasPengguna = [];

        if (auth()->user()->role === 'admin') {
            $aktivitasPengguna = User::orderBy('updated_at', 'desc')->take(5)->get();
        }

        return view('pages.reports.index', compact('aktivitasPengguna'));
    }

    public function transactions(Request $request)
    {
        $transactions = StockTransaction::with(['product.category', 'user'])
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                $query->whereBetween('date', [$request->start_date, $request->end_date]);
            })
            ->when($request->category_id, function ($query) use ($request) {
                $query->whereHas('product', function ($q) use ($request) {
                    $q->where('category_id', $request->category_id);
                });
            })
            ->latest('date')
            ->get();

        $categories = Category::all();

        return view('pages.reports.transactions', compact('transactions', 'categories'));
    }

    public function stocks(Request $request)
    {
        $products = $this->getProductsWithFinalStock(
            $request->category_id,
            $request->start_date,
            $request->end_date
        );

        $categories = Category::all();

        return view('pages.reports.stocks', compact('products', 'categories'));
    }


    /**
     * Ambil produk beserta stok akhir, dengan filter opsional:
     * - $categoryId: filter produk berdasarkan kategori
     * - $startDate/$endDate: hanya hitung transaksi dalam rentang tanggal ini
     */
    private function getProductsWithFinalStock($categoryId = null, $startDate = null, $endDate = null)
    {
        $query = Product::with(['category', 'transactions' => function ($q) use ($startDate, $endDate) {
            $q->select('id', 'product_id', 'type', 'quantity', 'status', 'date');

            if ($startDate && $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            }
        }]);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return $query->get()->map(function ($product) {
            $finalStock = $product->transactions
                ->reduce(function ($carry, $trx) {
                    if ($trx->type === 'Masuk' && $trx->status === 'Diterima') {
                        return $carry + $trx->quantity;
                    }
                    if ($trx->type === 'Keluar' && $trx->status === 'Dikeluarkan') {
                        return $carry - $trx->quantity;
                    }
                    return $carry;
                }, 0);

            $product->final_stock = $finalStock;
            return $product;
        });
    }
}