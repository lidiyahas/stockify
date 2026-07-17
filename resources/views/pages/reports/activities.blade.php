@extends('layouts.dashboard')

@section('content')
<div class="p-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">📋 Riwayat Aktivitas Pengguna</h2>

    {{-- Filter --}}
    <form method="GET" action="{{ route('reports.activities') }}" class="flex flex-wrap gap-3 mb-6">
        <select name="user_id" class="border border-gray-300 rounded-lg p-2 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option value="">Semua Pengguna</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>

        <select name="subject_type" class="border border-gray-300 rounded-lg p-2 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option value="">Semua Jenis Data</option>
            <option value="Product" {{ request('subject_type') == 'Product' ? 'selected' : '' }}>Produk</option>
            <option value="Category" {{ request('subject_type') == 'Category' ? 'selected' : '' }}>Kategori</option>
            <option value="Supplier" {{ request('subject_type') == 'Supplier' ? 'selected' : '' }}>Supplier</option>
            <option value="User" {{ request('subject_type') == 'User' ? 'selected' : '' }}>Pengguna</option>
            <option value="StockTransaction" {{ request('subject_type') == 'StockTransaction' ? 'selected' : '' }}>Transaksi Stok</option>
            <option value="ProductAttribute" {{ request('subject_type') == 'ProductAttribute' ? 'selected' : '' }}>Atribut Produk</option>
        </select>

        <button type="submit" class="px-4 py-2 bg-primary-700 text-white rounded-lg text-sm hover:bg-primary-800">
            Filter
        </button>

        @if(request('user_id') || request('subject_type'))
            <a href="{{ route('reports.activities') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 dark:text-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                Reset
            </a>
        @endif
    </form>

    {{-- Tabel aktivitas --}}
    <div class="bg-white rounded-lg shadow dark:bg-gray-800 overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-4 py-3">Waktu</th>
                    <th class="px-4 py-3">Pengguna</th>
                    <th class="px-4 py-3">Aksi</th>
                    <th class="px-4 py-3">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $log)
                    <tr class="border-b dark:border-gray-700">
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $log->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                            {{ $log->user->name ?? 'Sistem' }}
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $badgeColor = match($log->action) {
                                    'create' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                    'update' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                    'delete' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                    'approve' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'reject' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                    'opname' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
                                    default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                };
                            @endphp
                            <span class="text-xs font-semibold px-2 py-1 rounded {{ $badgeColor }}">
                                {{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $log->description }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                            Belum ada aktivitas tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $activities->appends(request()->query())->links() }}
    </div>
</div>
@endsection
