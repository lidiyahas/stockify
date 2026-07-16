{{-- resources/views/pages/products/attributes/create.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Tambah Atribut Produk')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Atribut Produk</h1>

        <form action="{{ route('attributes.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Pilih Produk --}}
            <div>
                <label for="product_id" class="block font-semibold text-gray-700 mb-1">
                    Produk 
                </label>
                <select name="product_id" id="product_id" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Atribut --}}
            <div>
                <label for="name" class="block font-semibold text-gray-700 mb-1">
                    Nama Atribut 
                </label>
                <input type="text" name="name" id="name" 
                       placeholder="Contoh: Warna, Ukuran" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                       value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nilai Atribut --}}
            <div>
                <label for="value" class="block font-semibold text-gray-700 mb-1">
                    Nilai 
                </label>
                <input type="text" name="value" id="value" 
                       placeholder="Contoh: Merah, XL" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                       value="{{ old('value') }}" required>
                @error('value')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex gap-3">
                <button type="submit" 
                    class="inline-flex items-center px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                     Simpan
                </button>

                <a href="{{ route('attributes.index') }}" 
                   class="inline-flex items-center px-5 py-2 bg-gray-500 text-white text-sm font-semibold rounded-lg shadow hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400">
                     Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
