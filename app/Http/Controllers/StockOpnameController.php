<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StockOpnameService;
use Illuminate\Support\Facades\Auth;

class StockOpnameController extends Controller
{
    private StockOpnameService $service;

    public function __construct(StockOpnameService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $products = $this->service->getProducts();
        return view('pages.opname.index', compact('products'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.stock' => 'required|integer|min:0'
        ]);

        $this->service->applyOpname($validated['products'], Auth::id());

        return redirect()->route('opname.index')->with('success', 'Stock opname berhasil disimpan.');
    }
}
