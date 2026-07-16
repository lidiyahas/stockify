@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-4">Stock Opname</h2>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Produk</th>
                    <th class="p-3">Stok</th>
                    <th class="p-3">Minimum Stok</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b {{ $product->stock < $product->minimum_stock ? 'bg-red-100' : '' }}">
                    <td class="p-3">{{ $product->name }}</td>
                    <td class="p-3">{{ $product->stock }}</td>
                    <td class="p-3">{{ $product->minimum_stock }}</td>
                    <td class="p-3">
                        @if($product->stock < $product->minimum_stock)
                            <span class="text-red-600 font-bold">Stok Rendah</span>
                        @else
                            <span class="text-green-600">Aman</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
