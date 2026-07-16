<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductAttributeController extends Controller
{

    public function __construct()
    {
        // Batasi akses hanya untuk admin pada fungsi tertentu
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                abort(403, 'Akses ditolak. Anda tidak memiliki hak akses.');
            }
            return $next($request);
        })->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    
    public function index()
    {
        $attributes = ProductAttribute::with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.attributes.index', compact('attributes'));
    }

    public function create()
    {
        $products = Product::all();
        return view('pages.attributes.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name'       => 'required|string|max:255',
            'value'      => 'required|string|max:255',
        ]);

        ProductAttribute::create($request->only(['product_id', 'name', 'value']));

        return redirect()
            ->route('attributes.index')
            ->with('success', 'Atribut produk berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $attribute = ProductAttribute::findOrFail($id);
        $products  = Product::all();

        return view('pages.attributes.edit', compact('attribute', 'products'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name'       => 'required|string|max:255',
            'value'      => 'required|string|max:255',
        ]);

        $attribute = ProductAttribute::findOrFail($id);
        $attribute->update($request->only(['product_id', 'name', 'value']));

        return redirect()
            ->route('attributes.index')
            ->with('success', 'Atribut produk berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $attribute = ProductAttribute::findOrFail($id);
        $attribute->delete();

        return redirect()
            ->route('attributes.index')
            ->with('success', 'Atribut produk berhasil dihapus.');
    }
}
