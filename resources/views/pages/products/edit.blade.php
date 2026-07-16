@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
         Edit Produk
    </h2>

    {{-- Notifikasi Error --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-5 shadow">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Edit Produk --}}
    <div class="bg-white rounded-lg shadow p-6 max-w-lg">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama Produk --}}
            <div>
                <label class="block font-semibold mb-2 text-gray-700">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan nama produk" required>
            </div>

            {{-- SKU --}}
            <div>
                <label class="block font-semibold mb-2 text-gray-700">SKU</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Kode SKU produk" required>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block font-semibold mb-2 text-gray-700">Deskripsi</label>
                <textarea name="description"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Deskripsi produk">{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- Harga Beli --}}
            <div>
                <label class="block font-semibold mb-2 text-gray-700">Harga Beli (Rp)</label>
                <input type="number" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    min="0" required>
            </div>

            {{-- Harga Jual --}}
            <div>
                <label class="block font-semibold mb-2 text-gray-700">Harga Jual (Rp)</label>
                <input type="number" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    min="0" required>
            </div>

            {{-- Stok Minimum --}}
            <div>
                <label class="block font-semibold mb-2 text-gray-700">Stok Minimum</label>
                <input type="number" name="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    min="0" required>
            </div>

            {{-- Gambar Produk --}}
            <div>
                <label class="block font-semibold mb-2 text-gray-700">Gambar Produk</label>
                <input type="file" name="image"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @if($product->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk" class="h-24 object-cover">
                    </div>
                @endif
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block font-semibold mb-2 text-gray-700">Kategori</label>
                <select name="category_id" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Supplier --}}
            <div>
                <label class="block font-semibold mb-2 text-gray-700">Supplier</label>
                <select name="supplier_id" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-4">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow">
                    Update
                </button>
                <a href="{{ route('products.index') }}"
                   class="text-gray-600 hover:text-gray-800 underline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection