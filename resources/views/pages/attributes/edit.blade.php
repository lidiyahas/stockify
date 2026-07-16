{{-- resources/views/pages/products/attributes/edit.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Edit Atribut Produk')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4"> Edit Atribut Produk</h1>

    <form action="{{ route('attributes.update', $attribute->id) }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-4">
        @csrf
        @method('PUT')

        {{-- Pilih Produk --}}
        <div>
            <label for="product_id" class="block font-medium mb-1">Produk </label>
            <select name="product_id" id="product_id" 
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400" required>
                <option value="">-- Pilih Produk --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id', $attribute->product_id) == $product->id ? 'selected' : '' }}>
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
            <label for="name" class="block font-medium mb-1">Nama Atribut</label>
            <input type="text" name="name" id="name" 
                   value="{{ old('name', $attribute->name) }}"
                   placeholder="Contoh: Warna, Ukuran"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nilai Atribut --}}
        <div>
            <label for="value" class="block font-medium mb-1">Nilai</label>
            <input type="text" name="value" id="value" 
                   value="{{ old('value', $attribute->value) }}"
                   placeholder="Contoh: Merah, XL"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400" required>
            @error('value')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex gap-3">
            <button type="submit" 
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-1">
                 Update
            </button>

            <a href="{{ route('attributes.index') }}" 
               class="px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
