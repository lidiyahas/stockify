@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800 flex items-center gap-2">
         Laporan
    </h2>

    {{-- Card Laporan --}}
    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'manajer_gudang')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Laporan Stok --}}
        <a href="{{ route('reports.stocks') }}" 
           class="bg-white p-6 rounded-xl shadow hover:shadow-lg hover:scale-105 transition transform duration-200 flex flex-col justify-between">
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2"> Laporan Stok Barang</h3>
                <p class="text-gray-500">Lihat stok barang terbaru dan kondisi stok minimum</p>
            </div>
            <span class="mt-4 text-blue-600 font-semibold inline-block">Lihat Detail →</span>
        </a>

        {{-- Laporan Transaksi --}}
        <a href="{{ route('reports.transactions') }}" 
           class="bg-white p-6 rounded-xl shadow hover:shadow-lg hover:scale-105 transition transform duration-200 flex flex-col justify-between">
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2"> Laporan Transaksi Stok</h3>
                <p class="text-gray-500">Lihat riwayat keluar masuk stok secara lengkap</p>
            </div>
            <span class="mt-4 text-green-600 font-semibold inline-block">Lihat Detail →</span>
        </a>
    </div>
    @endif

    <!-- Aktivitas Pengguna -->
    @if(Auth::user()->role === 'admin')
    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4">
        <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">👥 Aktivitas Pengguna Terbaru</h3>
        <ul>
            @foreach($aktivitasPengguna as $user)
                <li class="py-2 border-b border-gray-200 dark:border-gray-700 flex justify-between">
                    <span>{{ $user->name }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $user->updated_at->diffForHumans() }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection
