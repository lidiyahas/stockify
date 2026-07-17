@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            Detail Produk
        </h2>
        <a href="{{ route('products.index') }}" class="text-sm text-blue-600 hover:underline">
            &larr; Kembali ke Daftar Produk
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

        {{-- Gambar & info utama --}}
        <div class="bg-white rounded-lg shadow p-6 md:col-span-1">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
            @else
                <div class="w-full h-48 bg-gray-100 rounded-lg mb-4 flex items-center justify-center text-gray-400 italic">
                    Tidak ada gambar
                </div>
            @endif

            <h3 class="text-xl font-bold text-gray-900">{{ $product->name }}</h3>
            <p class="text-sm text-gray-500 mb-4">SKU: {{ $product->sku ?? '-' }}</p>

            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Kategori</span>
                    <span class="font-medium">{{ $product->category->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Supplier</span>
                    <span class="font-medium">{{ $product->supplier->name ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Detail harga & stok --}}
        <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
            <h4 class="font-semibold text-gray-800 mb-4">Informasi Produk</h4>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="p-4 rounded-lg bg-gray-50">
                    <p class="text-xs text-gray-500 mb-1">Harga Beli</p>
                    <p class="text-lg font-bold text-gray-800">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 rounded-lg bg-gray-50">
                    <p class="text-xs text-gray-500 mb-1">Harga Jual</p>
                    <p class="text-lg font-bold text-gray-800">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 rounded-lg {{ $stokSaatIni < $product->minimum_stock ? 'bg-red-50' : 'bg-green-50' }}">
                    <p class="text-xs text-gray-500 mb-1">Stok Saat Ini</p>
                    <p class="text-lg font-bold {{ $stokSaatIni < $product->minimum_stock ? 'text-red-600' : 'text-green-600' }}">
                        {{ $stokSaatIni }}
                    </p>
                </div>
                <div class="p-4 rounded-lg bg-gray-50">
                    <p class="text-xs text-gray-500 mb-1">Stok Minimum</p>
                    <p class="text-lg font-bold text-gray-800">{{ $product->minimum_stock }}</p>
                </div>
            </div>

            @if($stokSaatIni < $product->minimum_stock)
                <div class="bg-red-100 text-red-800 text-sm px-4 py-2 rounded-lg mb-4">
                    ⚠️ Stok produk ini sudah di bawah batas minimum.
                </div>
            @endif

            <h4 class="font-semibold text-gray-800 mb-2">Deskripsi</h4>
            <p class="text-sm text-gray-600 mb-4">{{ $product->description ?: 'Tidak ada deskripsi.' }}</p>

            @if($product->attributes->isNotEmpty())
                <h4 class="font-semibold text-gray-800 mb-2">Atribut Produk</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach($product->attributes as $attr)
                        <span class="text-xs bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                            {{ $attr->name }}: {{ $attr->value }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Riwayat transaksi terbaru --}}
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <h4 class="font-semibold text-gray-800 p-4 border-b">Riwayat Transaksi Terbaru</h4>
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Jenis</th>
                    <th class="px-6 py-3 text-center">Jumlah</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Dicatat oleh</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatTransaksi as $trx)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">{{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}</td>
                        <td class="px-6 py-3">
                            <span class="text-xs font-semibold px-2 py-1 rounded {{ $trx->type === 'Masuk' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $trx->type }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-center">{{ $trx->quantity }}</td>
                        <td class="px-6 py-3">{{ $trx->status }}</td>
                        <td class="px-6 py-3">{{ $trx->user->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">
                            Belum ada transaksi untuk produk ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
