@extends('layouts.dashboard')

@section('content')
<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Manajemen Supplier</h2>
    @if(Auth::user()->role === 'admin')
    <a href="{{ route('suppliers.create') }}" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Supplier</a>
    @endif

    <div class="bg-white rounded shadow p-4">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Alamat</th>
                    <th class="px-4 py-2">Telepon</th>
                    <th class="px-4 py-2">Email</th>
                    @if(Auth::user()->role === 'admin')
                    <th class="px-4 py-2">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $supplier->name }}</td>
                        <td class="px-4 py-2">{{ $supplier->address }}</td>
                        <td class="px-4 py-2">{{ $supplier->phone }}</td>
                        <td class="px-4 py-2">{{ $supplier->email }}</td>
                        <td class="px-4 py-2 space-x-2">
                            @if(Auth::user()->role === 'admin')
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection