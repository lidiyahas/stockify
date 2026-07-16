@extends('layouts.dashboard')

@section('title', 'Edit Kategori Produk')

@section('content')
<div class="container mx-auto max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Edit Kategori Produk</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 border border-red-300 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow border border-gray-200">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $category->name) }}"
                   class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                   required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" id="description" rows="3"
                      class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit"
                    class="px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-lg shadow hover:bg-yellow-600">
                Update
            </button>
            <a href="{{ route('categories.index') }}"
               class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded-lg shadow hover:bg-gray-400">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
