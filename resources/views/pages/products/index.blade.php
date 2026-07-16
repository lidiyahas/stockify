@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        Daftar Produk
    </h2>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between mb-6">
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('products.create') }}" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow">
                + Tambah Produk
            </a>
        @endif
    <div class="flex gap-2">
        <a href="{{ route('products.export') }}" 
           class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700">
           Export Excel
        </a>

        <button type="button" onclick="document.getElementById('importModal').classList.remove('hidden')"
                class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600">
           Import Excel
        </button>
    </div>
</div>

{{-- Modal Import sederhana --}}
<div id="importModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow w-full max-w-md">
        <h3 class="text-lg font-bold mb-4">Import Data Produk</h3>
        <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                   class="w-full border rounded p-2 mb-4">
            <p class="text-sm text-gray-500 mb-4">
                Format kolom: nama_produk, sku, kategori, supplier, deskripsi, harga_beli, harga_jual, stok_minimum
            </p>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Upload
                </button>
                <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')"
                        class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
    
    {{-- Tabel Produk --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full text-sm text-left border border-gray-200">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">SKU</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Supplier</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3 text-center">Harga Beli</th>
                    <th class="px-6 py-3 text-right">Harga Jual</th>
                    <th class="px-6 py-3 text-center">Stok</th>
                    <th class="px-6 py-3 text-center">Gambar</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $product->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $product->sku }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $product->category->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $product->supplier->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ Str::limit($product->description, 50) }}
                        </td>
                        <td class="px-6 py-4 text-center text-gray-600">
                            Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right text-gray-800">
                            Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center text-gray-600">
                            {{ $product->minimum_stock }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Produk" class="h-12 w-12 object-cover rounded">
                            @else
                                <span class="text-gray-400 italic">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 flex items-center justify-center gap-3">
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('products.edit', $product->id) }}" 
                                    class="text-blue-600 hover:text-blue-800 font-medium">
                                    Edit
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                                    onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                        Hapus
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 italic">Tidak ada aksi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center py-6 text-gray-500">
                            Belum ada produk yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection