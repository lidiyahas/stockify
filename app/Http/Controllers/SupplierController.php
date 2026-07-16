<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    private SupplierService $service;

    public function __construct(SupplierService $service)
    {
        $this->service = $service;

        // Admin & Manajer Gudang boleh lihat daftar supplier
        $this->middleware(function ($request, $next) {
            if (! in_array(Auth::user()->role, ['admin', 'manajer_gudang'])) {
                abort(403, 'Akses ditolak. Anda tidak memiliki hak akses.');
            }
            return $next($request);
        })->only(['index']);

        // Hanya Admin yang boleh CRUD (tambah/ubah/hapus)
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                abort(403, 'Akses ditolak. Anda tidak memiliki hak akses.');
            }
            return $next($request);
        })->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $suppliers = $this->service->getAll();
        return view('components.manajemen_suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('components.manajemen_suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'phone'   => 'required|string|max:20',
            'email'   => 'required|email|unique:suppliers,email',
        ]);

        $this->service->create($validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan');
    }

    public function edit(Supplier $supplier)
    {
        return view('components.manajemen_suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'phone'   => 'required|string|max:20',
            'email'   => 'required|email|unique:suppliers,email,' . $supplier->id,
        ]);

        $this->service->update($supplier, $validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui');
    }

    public function destroy(Supplier $supplier)
    {
        $this->service->delete($supplier);
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus');
    }
}
