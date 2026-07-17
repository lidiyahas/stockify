<?php

namespace App\Services\Impl;

use App\Services\DashboardService;
use App\Services\ActivityLogService;
use App\Repositories\DashboardRepository;
use Carbon\Carbon;

class DashboardServiceImpl implements DashboardService
{
    private DashboardRepository $repo;
    private ActivityLogService $activityLog;

    public function __construct(DashboardRepository $repo, ActivityLogService $activityLog)
    {
        $this->repo = $repo;
        $this->activityLog = $activityLog;
    }

    public function getDashboardData(string $role, ?string $startDate = null, ?string $endDate = null): array
    {
        // Default periode: 30 hari terakhir, kalau user tidak memilih rentang tanggal sendiri
        $periodeAwal = $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->subDays(30)->startOfDay();
        $periodeAkhir = $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfDay();

        $products = $this->repo->getProductsWithTransactions();

        $stokPerProduk = $products->map(function ($product) {
            $stok = $product->transactions->reduce(function ($carry, $trx) {
                if ($trx->type === 'Masuk' && $trx->status === 'Diterima') {
                    return $carry + $trx->quantity;
                }
                if ($trx->type === 'Keluar' && $trx->status === 'Dikeluarkan') {
                    return $carry - $trx->quantity;
                }
                return $carry;
            }, 0);

            return [
                'name' => $product->name,
                'category' => $product->category->name ?? 'Tanpa Kategori',
                'stock' => $stok,
                'minimum_stock' => $product->minimum_stock,
            ];
        });

        // Untuk Manajer/Staff/Admin: daftar produk yang stoknya di bawah minimum (peringatan)
        $grafikStok = $stokPerProduk
            ->filter(fn($item) => $item['stock'] < $item['minimum_stock'])
            ->sortBy('stock')
            ->values();

        // Khusus Admin: grafik stok keseluruhan, diringkas per kategori
        $grafikStokKategori = collect();
        if ($role === 'admin') {
            $grafikStokKategori = $stokPerProduk
                ->groupBy('category')
                ->map(function ($items, $kategori) {
                    return [
                        'category' => $kategori,
                        'total_stock' => $items->sum('stock'),
                        'jumlah_produk' => $items->count(),
                    ];
                })
                ->sortByDesc('total_stock')
                ->values();
        }

        $jumlahProduk = null;
        $aktivitasPengguna = collect();
        $barangMasukPending = collect();
        $barangKeluarPending = collect();
        $transaksiMasuk = null;
        $transaksiKeluar = null;
        $barangMasukHariIni = null;
        $barangKeluarHariIni = null;

        if ($role === 'admin') {
            $jumlahProduk = $this->repo->countProducts();
            $aktivitasPengguna = $this->activityLog->getRecent(5);

            // Admin: total transaksi sesuai periode yang dipilih (default 30 hari)
            $transaksiMasuk = $this->repo->countTransactionsInRange('Masuk', $periodeAwal, $periodeAkhir);
            $transaksiKeluar = $this->repo->countTransactionsInRange('Keluar', $periodeAwal, $periodeAkhir);
        }

        if ($role === 'manajer_gudang') {
            // Manajer: fokusnya hari ini, bukan periode custom
            $awalHariIni = Carbon::now()->startOfDay();
            $akhirHariIni = Carbon::now()->endOfDay();

            $barangMasukHariIni = $this->repo->countTransactionsInRange('Masuk', $awalHariIni, $akhirHariIni);
            $barangKeluarHariIni = $this->repo->countTransactionsInRange('Keluar', $awalHariIni, $akhirHariIni);
        }

        if ($role === 'staff_gudang') {
            $barangMasukPending = $this->repo->pendingTransactions('Masuk');
            $barangKeluarPending = $this->repo->pendingTransactions('Keluar');
        }

        return [
            'jumlahProduk' => $jumlahProduk,
            'transaksiMasuk' => $transaksiMasuk,
            'transaksiKeluar' => $transaksiKeluar,
            'barangMasukHariIni' => $barangMasukHariIni,
            'barangKeluarHariIni' => $barangKeluarHariIni,
            'grafikStok' => $grafikStok,
            'grafikStokKategori' => $grafikStokKategori,
            'aktivitasPengguna' => $aktivitasPengguna,
            'barangMasukPending' => $barangMasukPending,
            'barangKeluarPending' => $barangKeluarPending,
            'role' => $role,
            'periodeAwal' => $periodeAwal->format('Y-m-d'),
            'periodeAkhir' => $periodeAkhir->format('Y-m-d'),
        ];
    }
}
