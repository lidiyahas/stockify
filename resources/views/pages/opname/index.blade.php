@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-6">Stock Opname</h2>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-5 shadow">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('opname.update') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-50 border-b text-gray-700">
                        <th class="px-6 py-3 text-left text-sm font-semibold">Produk</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold">Stok Sistem</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold">Stok Fisik</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $index => $product)
                        @php
                            $stockIn = $product->transactions->where('type', 'Masuk')->where('status', 'Diterima')->sum('quantity');
                            $stockOut = $product->transactions->where('type', 'Keluar')->where('status', 'Dikeluarkan')->sum('quantity');
                            $currentStock = $stockIn - $stockOut;
                        @endphp
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $product->name }}</td>
                            <td class="px-6 py-3 text-center text-sm text-gray-600">{{ $currentStock }}</td>
                            <td class="px-6 py-3 text-center">
                                <input type="hidden" name="products[{{ $index }}][id]" value="{{ $product->id }}">
                                <input type="number" name="products[{{ $index }}][stock]" value="{{ $currentStock }}"
                                    class="border border-gray-300 rounded-lg p-2 w-28 text-center focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
