<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductAttributeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductAttributeController extends Controller
{
    private ProductAttributeService $service;

    public function __construct(ProductAttributeService $service)
    {
        $this->service = $service;

        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                abort(403, 'Akses ditolak. Anda tidak memiliki hak akses.');
            }
            return $next($request);
        })->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $attributes = $this->service->getPaginated(10);
        return view('pages.attributes.index', compact('attributes'));
    }

    public function create()
    {
        $products = Product::all();
        return view('pages.attributes.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name'       => 'required|string|max:255',
            'value'      => 'required|string|max:255',
        ]);

        $this->service->create($validated);

        return redirect()->route('attributes.index')->with('success', 'Atribut produk berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $attribute = $this->service->find($id);
        $products  = Product::all();

        return view('pages.attributes.edit', compact('attribute', 'products'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name'       => 'required|string|max:255',
            'value'      => 'required|string|max:255',
        ]);

        $this->service->update($id, $validated);

        return redirect()->route('attributes.index')->with('success', 'Atribut produk berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);
        return redirect()->route('attributes.index')->with('success', 'Atribut produk berhasil dihapus.');
    }
}
