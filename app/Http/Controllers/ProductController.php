<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Tampilkan daftar produk
     */
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->latest()->paginate(10);
        return view('pages.products.index', compact('products'));
    }

    /**
     * Export data produk ke Excel
     */
    public function export()
    {
        return Excel::download(new ProductsExport, 'data-produk-' . now()->format('Y-m-d') . '.xlsx');
    }

    /**
     * Import data produk dari Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        $import = new ProductsImport;
        Excel::import($import, $request->file('file'));

        // Cek apakah ada baris yang gagal (kategori/supplier tidak ditemukan, sku duplikat, dll)
        if ($import->failures()->isNotEmpty()) {
            $errorMessages = [];

            foreach ($import->failures() as $failure) {
                $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }

            return redirect()->route('products.index')
                ->with('warning', 'Sebagian data berhasil diimport, tapi ada baris yang gagal:')
                ->with('import_errors', $errorMessages);
        }

        return redirect()->route('products.index')->with('success', 'Data produk berhasil diimport.');
    }

    /**
     * Form tambah produk
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('pages.products.create', compact('categories', 'suppliers'));
    }

    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'supplier_id'      => 'required|exists:suppliers,id',
            'name'             => 'required|string|max:255',
            'sku'              => 'nullable|string|max:100|unique:products,sku',
            'description'      => 'nullable|string',
            'purchase_price'   => 'required|numeric|min:0',
            'selling_price'    => 'required|numeric|min:0',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'minimum_stock'    => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Form edit produk
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('pages.products.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Update produk
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'supplier_id'      => 'required|exists:suppliers,id',
            'name'             => 'required|string|max:255',
            'sku'              => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'description'      => 'nullable|string',
            'purchase_price'   => 'required|numeric|min:0',
            'selling_price'    => 'required|numeric|min:0',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'minimum_stock'    => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}