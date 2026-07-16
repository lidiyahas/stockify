{{-- resources/views/pages/products/attributes/index.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Atribut Produk')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Daftar Atribut Produk</h1>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 border border-green-300 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol tambah --}}
    <div class="mb-4">
        <a href="{{ route('attributes.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-1">
            ➕ Tambah Atribut
        </a>
    </div>

    {{-- Tabel daftar atribut --}}
    <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
        <table class="w-full text-sm border-collapse">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 border-b text-center w-[60px]">ID</th>
                    <th class="px-4 py-3 border-b w-[25%]">Produk</th>
                    <th class="px-4 py-3 border-b w-[25%]">Nama Atribut</th>
                    <th class="px-4 py-3 border-b w-[25%]">Nilai</th>
                    <th class="px-4 py-3 border-b text-center w-[120px]">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attributes as $attr)
                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100 transition">
                        <td class="px-4 py-3 border-b text-center font-medium">{{ $attr->id }}</td>
                        <td class="px-4 py-3 border-b truncate">{{ $attr->product->name ?? '-' }}</td>
                        <td class="px-4 py-3 border-b truncate">{{ $attr->name }}</td>
                        <td class="px-4 py-3 border-b truncate">{{ $attr->value }}</td>
                        <td class="px-4 py-3 border-b text-center">
                            <div class="flex justify-center gap-1">
                                <a href="{{ route('attributes.edit', $attr->id) }}" 
                                   class="px-3 py-1 bg-yellow-500 text-white text-xs font-medium rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                                    Edit
                                </a>
                                <form action="{{ route('attributes.destroy', $attr->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus atribut ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1 bg-red-500 text-white text-xs font-medium rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                            Belum ada atribut yang ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
