@extends('layouts.dashboard')

@section('content')
<div class="p-4">

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Barang Masuk Hari Ini -->
        <div class="p-4 rounded-lg shadow text-white bg-gradient-to-r from-green-500 to-green-600 flex items-center gap-4">
            <div class="bg-white bg-opacity-20 p-3 rounded-full text-2xl">📥</div>
            <div>
                <h3 class="text-sm font-medium">Barang Masuk Hari Ini</h3>
                <p class="mt-1 text-3xl font-bold">{{ $barangMasukHariIni }}</p>
            </div>
        </div>

        <!-- Barang Keluar Hari Ini -->
        <div class="p-4 rounded-lg shadow text-white bg-gradient-to-r from-red-500 to-red-600 flex items-center gap-4">
            <div class="bg-white bg-opacity-20 p-3 rounded-full text-2xl">📤</div>
            <div>
                <h3 class="text-sm font-medium">Barang Keluar Hari Ini</h3>
                <p class="mt-1 text-3xl font-bold">{{ $barangKeluarHariIni }}</p>
            </div>
        </div>

        <!-- Stok Menipis Count -->
        <div class="p-4 rounded-lg shadow text-white bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center gap-4">
            <div class="bg-white bg-opacity-20 p-3 rounded-full text-2xl">⚠️</div>
            <div>
                <h3 class="text-sm font-medium">Produk Stok Menipis</h3>
                <p class="mt-1 text-3xl font-bold">{{ $stokMenipis->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Daftar Produk Stok Menipis -->
    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4">
        <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">⚠️ Daftar Produk Stok Menipis</h3>
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Produk</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Stok</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @forelse($stokMenipis as $produk)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $produk->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $produk->stock }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-4 py-2 text-center text-gray-500">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
