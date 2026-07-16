@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
         Laporan Transaksi Stok
    </h2>

{{-- Filter --}}
    <form method="GET" class="bg-white p-4 rounded-lg shadow mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block mb-1 font-medium text-gray-700">Kategori</label>
            <select name="category_id" class="border rounded p-2 focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-1 font-medium text-gray-700">Dari Tanggal</label>
            <input type="date" name="start_date" class="border rounded p-2 focus:ring-2 focus:ring-blue-500"
                   value="{{ request('start_date') }}">
        </div>
        <div>
            <label class="block mb-1 font-medium text-gray-700">Sampai Tanggal</label>
            <input type="date" name="end_date" class="border rounded p-2 focus:ring-2 focus:ring-blue-500"
                   value="{{ request('end_date') }}">
        </div>
        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 shadow">
                 Filter
            </button>
            <a href="{{ route('reports.transactions') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-300 shadow">
                Reset
            </a>
        </div>
    </form>

    {{-- Tabel Laporan --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full border border-gray-200 rounded-lg">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-left">
                    <th class="p-3 border-b">Tanggal</th>
                    <th class="p-3 border-b">Produk</th>
                    <th class="p-3 border-b">Kategori</th>
                    <th class="p-3 border-b">Jenis</th>
                    <th class="p-3 border-b">Jumlah</th>
                    <th class="p-3 border-b">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border-b">{{ \Carbon\Carbon::parse($trx->date)->format('d-m-Y') }}</td>
                        <td class="p-3 border-b">{{ $trx->product->name ?? '-' }}</td>
                        <td class="p-3 border-b">{{ $trx->product->category->name ?? '-' }}</td>
                        <td class="p-3 border-b">
                            <span class="px-2 py-1 rounded text-sm 
                                {{ $trx->type == 'Masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $trx->type }}
                            </span>
                        </td>
                        <td class="p-3 border-b font-semibold">{{ $trx->quantity }}</td>
                        <td class="p-3 border-b">
                            <span class="px-2 py-1 rounded text-sm
                                @if($trx->status == 'Pending') bg-yellow-100 text-yellow-700
                                @elseif($trx->status == 'Diterima') bg-green-100 text-green-700
                                @elseif($trx->status == 'Ditolak') bg-red-100 text-red-700
                                @elseif($trx->status == 'Dikeluarkan') bg-blue-100 text-blue-700
                                @endif">
                                {{ $trx->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection