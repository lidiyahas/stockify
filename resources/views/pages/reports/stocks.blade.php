@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
         Laporan Stok Barang
    </h2>

    {{-- Form Filter --}}
    <form action="{{ route('reports.stocks') }}" method="GET" class="bg-white p-4 rounded-lg shadow mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
            <select name="category_id" class="border rounded p-2">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="border rounded p-2">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="border rounded p-2">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700">
                Terapkan Filter
            </button>
            <a href="{{ route('reports.stocks') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg shadow hover:bg-gray-300">
                Reset
            </a>
        </div>
    </form>

    {{-- Tabel Laporan --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full border border-gray-200 rounded-lg">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-left">
                    <th class="p-3 border-b">Nama Produk</th>
                    <th class="p-3 border-b">Kategori</th>
                    <th class="p-3 border-b">Stok Saat Ini</th>
                    <th class="p-3 border-b">Minimum Stok Produk</th>
                    <th class="p-3 border-b">Harga</th>
                    <th class="p-3 border-b">Terakhir Update</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border-b font-medium">{{ $product->name }}</td>
                        <td class="p-3 border-b">{{ $product->category->name ?? '-' }}</td>

                        <td class="p-3 border-b {{ $product->final_stock < $product->minimum_stock ? 'text-red-600 font-bold' : 'text-gray-800' }}">
                            {{ $product->final_stock }}
                        </td>

                        <td class="p-3 border-b">{{ $product->minimum_stock }}</td>
                        <td class="p-3 border-b">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                        <td class="p-3 border-b">{{ $product->updated_at->format('d-m-Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data produk</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection