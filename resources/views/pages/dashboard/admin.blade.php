@extends('layouts.dashboard')

@section('content')
<div class="p-4">

    {{-- Filter periode transaksi (khusus Admin) --}}
    @if(Auth::user()->role === 'admin')
    <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap items-end gap-3 mb-4">
        <div>
            <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ $periodeAwal }}"
                   class="border border-gray-300 rounded-lg p-2 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        <div>
            <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ $periodeAkhir }}"
                   class="border border-gray-300 rounded-lg p-2 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        <button type="submit" class="px-4 py-2 bg-primary-700 text-white rounded-lg text-sm hover:bg-primary-800">
            Terapkan
        </button>
        <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 dark:text-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
            Reset (30 Hari Terakhir)
        </a>
    </form>
    @endif

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        {{-- Hanya admin yang bisa lihat jumlah produk --}}
        @if(Auth::user()->role === 'admin')
        <!-- Jumlah Produk -->
        <div class="p-4 rounded-lg shadow text-white bg-gradient-to-r from-blue-500 to-blue-600 flex items-center gap-4">
            <div class="bg-white bg-opacity-20 p-3 rounded-full text-2xl">📦</div>
            <div>
                <h3 class="text-sm font-medium">Jumlah Produk</h3>
                <p class="mt-1 text-3xl font-bold">{{ $jumlahProduk }}</p>
            </div>
        </div>
        @endif      


        <!-- Transaksi Masuk/Keluar (Admin: sesuai periode yang dipilih) -->
        @if(Auth::user()->role === 'admin')
        <div class="p-4 rounded-lg shadow text-white bg-gradient-to-r from-green-500 to-green-600 flex items-center gap-4">
            <div class="bg-white bg-opacity-20 p-3 rounded-full text-2xl">📥</div>
            <div>
                <h3 class="text-sm font-medium">Transaksi Masuk ({{ \Carbon\Carbon::parse($periodeAwal)->format('d M') }} - {{ \Carbon\Carbon::parse($periodeAkhir)->format('d M Y') }})</h3>
                <p class="mt-1 text-3xl font-bold">{{ $transaksiMasuk }}</p>
            </div>
        </div>

        <div class="p-4 rounded-lg shadow text-white bg-gradient-to-r from-red-500 to-red-600 flex items-center gap-4">
            <div class="bg-white bg-opacity-20 p-3 rounded-full text-2xl">📤</div>
            <div>
                <h3 class="text-sm font-medium">Transaksi Keluar ({{ \Carbon\Carbon::parse($periodeAwal)->format('d M') }} - {{ \Carbon\Carbon::parse($periodeAkhir)->format('d M Y') }})</h3>
                <p class="mt-1 text-3xl font-bold">{{ $transaksiKeluar }}</p>
            </div>
        </div>
        @endif

        <!-- Barang Masuk/Keluar Hari Ini (khusus Manajer Gudang) -->
        @if(Auth::user()->role === 'manajer_gudang')
        <div class="p-4 rounded-lg shadow text-white bg-gradient-to-r from-green-500 to-green-600 flex items-center gap-4">
            <div class="bg-white bg-opacity-20 p-3 rounded-full text-2xl">📥</div>
            <div>
                <h3 class="text-sm font-medium">Barang Masuk Hari Ini</h3>
                <p class="mt-1 text-3xl font-bold">{{ $barangMasukHariIni }}</p>
            </div>
        </div>

        <div class="p-4 rounded-lg shadow text-white bg-gradient-to-r from-red-500 to-red-600 flex items-center gap-4">
            <div class="bg-white bg-opacity-20 p-3 rounded-full text-2xl">📤</div>
            <div>
                <h3 class="text-sm font-medium">Barang Keluar Hari Ini</h3>
                <p class="mt-1 text-3xl font-bold">{{ $barangKeluarHariIni }}</p>
            </div>
        </div>
        @endif

    </div>

    <!-- Grafik stok barang keseluruhan (khusus Admin) -->
    @if(Auth::user()->role === 'admin')
    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4 mb-6">
        <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">📊 Grafik Stok Barang (per Kategori)</h3>

        @if($grafikStokKategori->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada data stok untuk ditampilkan.</p>
        @else
            <div class="relative h-72">
                <canvas id="stokKategoriChart"></canvas>
            </div>
        @endif
    </div>
    @endif

    <!-- Grafik stok barang menipis -->
    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'manajer_gudang')
    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4 mb-6">
        <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">📊 Stok Barang Menipis</h3>

        @if($grafikStok->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400">Semua stok barang masih aman, tidak ada yang di bawah batas minimum.</p>
        @else
            <div class="relative h-72 mb-4">
                <canvas id="stokChart"></canvas>
            </div>

            {{-- Keterangan detail per produk --}}
            <div class="space-y-2 border-t border-gray-200 dark:border-gray-700 pt-4">
                @foreach($grafikStok as $index => $item)
                    @php
                        $colorScale = [
                            'rgb(220, 38, 38)',
                            'rgb(239, 68, 68)',
                            'rgb(249, 115, 22)',
                            'rgb(234, 179, 8)',
                            'rgb(34, 197, 94)',
                        ];
                        $color = $colorScale[$index] ?? 'rgb(59, 130, 246)';
                    @endphp
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-3 h-3 rounded-full" style="background-color: {{ $color }}"></span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $item['name'] }}</span>
                        </div>
                        <div class="text-gray-600 dark:text-gray-400">
                            Stok saat ini: <span class="font-semibold text-red-600 dark:text-red-400">{{ $item['stock'] }}</span>
                            &nbsp;/&nbsp;
                            Minimal: <span class="font-semibold">{{ $item['minimum_stock'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    @endif

    <!-- Aktivitas Pengguna -->
    @if(Auth::user()->role === 'admin')
    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4">
        <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">👥 Aktivitas Pengguna Terbaru</h3>
        <ul>
            @forelse($aktivitasPengguna as $log)
                <li class="py-2 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between">
                        <span class="font-medium">{{ $log->user->name ?? 'Sistem' }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $log->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $log->description }}</p>
                </li>
            @empty
                <li class="py-2 text-sm text-gray-500 dark:text-gray-400">Belum ada aktivitas tercatat.</li>
            @endforelse
        </ul>
        <a href="{{ route('reports.activities') }}" class="block mt-3 text-sm text-primary-700 dark:text-primary-400 hover:underline">Lihat semua aktivitas &rarr;</a>
    </div>
    @endif
</div>

{{-- Jobdesk Staff Gudang: Transaksi Pending --}}
@if($role === 'staff_gudang')
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    {{-- Barang Masuk Perlu Diperiksa --}}
    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4">
        <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">📥 Barang Masuk Perlu Diperiksa</h3>

        @if($barangMasukPending->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada tugas saat ini.</p>
        @else
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($barangMasukPending as $trx)
                    <li class="py-3 flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $trx->product->name ?? '-' }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Jumlah: {{ $trx->quantity }} • {{ \Carbon\Carbon::parse($trx->date)->format('d-m-Y') }}
                            </p>
                        </div>
                        <a href="{{ route('transactions.edit', $trx->id) }}"
                           class="text-sm font-medium text-blue-600 hover:underline">
                            Periksa
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Barang Keluar Perlu Disiapkan --}}
    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4">
        <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">📤 Barang Keluar Perlu Disiapkan</h3>

        @if($barangKeluarPending->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada tugas saat ini.</p>
        @else
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($barangKeluarPending as $trx)
                    <li class="py-3 flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $trx->product->name ?? '-' }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Jumlah: {{ $trx->quantity }} • {{ \Carbon\Carbon::parse($trx->date)->format('d-m-Y') }}
                            </p>
                        </div>
                        <a href="{{ route('transactions.edit', $trx->id) }}"
                           class="text-sm font-medium text-blue-600 hover:underline">
                            Siapkan
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endif

@if(($grafikStok ?? collect())->isNotEmpty() && (Auth::user()->role === 'admin' || Auth::user()->role === 'manajer_gudang'))
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const stokData = @json($grafikStok);

    // Gradasi warna dari merah (paling parah) ke hijau (paling ringan di antara yang menipis)
    const colorScale = [
        'rgba(220, 38, 38, 0.9)',
        'rgba(239, 68, 68, 0.85)',
        'rgba(249, 115, 22, 0.85)',
        'rgba(234, 179, 8, 0.85)',
        'rgba(34, 197, 94, 0.85)',
    ];

    const backgroundColors = stokData.map((item, index) => colorScale[index] ?? 'rgba(59, 130, 246, 0.8)');

    const ctx = document.getElementById('stokChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: stokData.map(item => item.name),
            datasets: [{
                label: 'Stok Saat Ini',
                data: stokData.map(item => item.stock),
                backgroundColor: backgroundColors,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#fff',
                    bodyColor: '#d1d5db',
                    callbacks: {
                        afterLabel: function(context) {
                            const item = stokData[context.dataIndex];
                            return 'Minimal: ' + item.minimum_stock;
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: '#6b7280' },
                    grid: { color: 'rgba(107, 114, 128, 0.1)' }
                },
                y: {
                    ticks: { color: '#6b7280', precision: 0 },
                    grid: { color: 'rgba(107, 114, 128, 0.1)' }
                }
            }
        }
    });
</script>
@endif

@if(($grafikStokKategori ?? collect())->isNotEmpty() && Auth::user()->role === 'admin')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const kategoriData = @json($grafikStokKategori);

    const ctxKategori = document.getElementById('stokKategoriChart').getContext('2d');
    new Chart(ctxKategori, {
        type: 'bar',
        data: {
            labels: kategoriData.map(item => item.category),
            datasets: [{
                label: 'Total Stok',
                data: kategoriData.map(item => item.total_stock),
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#fff',
                    bodyColor: '#d1d5db',
                    callbacks: {
                        afterLabel: function(context) {
                            const item = kategoriData[context.dataIndex];
                            return item.jumlah_produk + ' produk';
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: '#6b7280' },
                    grid: { color: 'rgba(107, 114, 128, 0.1)' }
                },
                y: {
                    ticks: { color: '#6b7280', precision: 0 },
                    grid: { color: 'rgba(107, 114, 128, 0.1)' }
                }
            }
        }
    });
</script>
@endif
@endsection
