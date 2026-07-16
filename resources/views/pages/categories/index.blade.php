@extends('layouts.dashboard')

@section('title', 'Kategori Produk')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Daftar Kategori Produk</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 border border-green-300 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('categories.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700">
            ➕ Tambah Kategori
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border-b text-center w-12">ID</th>
                    <th class="px-4 py-2 border-b">Nama Kategori</th>
                    <th class="px-4 py-2 border-b">Deskripsi</th>
                    <th class="px-4 py-2 border-b text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100 transition">
                        <td class="px-4 py-2 border-b text-center">{{ $category->id }}</td>
                        <td class="px-4 py-2 border-b">{{ $category->name }}</td>
                        <td class="px-4 py-2 border-b">
                            {{ $category->description ?: '-' }}
                        </td>
                        <td class="px-4 py-2 border-b text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('categories.edit', $category->id) }}" 
                                   class="px-3 py-1 bg-yellow-500 text-white text-xs font-medium rounded hover:bg-yellow-600">
                                    Edit
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1 bg-red-500 text-white text-xs font-medium rounded hover:bg-red-600">
                                         Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                            Belum ada kategori.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
