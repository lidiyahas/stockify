<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\Auth;

class StockOpnameController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pages.opname.index', compact('products'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.stock' => 'required|integer|min:0'
        ]);

        foreach ($validated['products'] as $productData) {
            $product = Product::find($productData['id']);

            // Hitung stok sistem saat ini
            $in = $product->transactions()->where('type', 'Masuk')->where('status', 'Diterima')->sum('quantity');
            $out = $product->transactions()->where('type', 'Keluar')->where('status', 'Dikeluarkan')->sum('quantity');
            $currentStock = $in - $out;

            $selisih = $productData['stock'] - $currentStock;

            if ($selisih != 0) {
                StockTransaction::create([
                    'product_id' => $product->id,
                    'type' => $selisih > 0 ? 'Masuk' : 'Keluar',
                    'quantity' => abs($selisih),
                    'status' => $selisih > 0 ? 'Diterima' : 'Dikeluarkan',
                    'notes' => 'Penyesuaian melalui stok opname',
                    'user_id' => Auth::id(),
                    'date' => now()
                ]);
            }
        }

        return redirect()->route('opname.index')->with('success', 'Stock opname berhasil disimpan.');
    }
}
