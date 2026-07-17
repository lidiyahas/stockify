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

    public function getDashboardData(string $role): array
    {
        $startDate = Carbon::now()->subDays(30);

        $grafikStok = $this->repo->getProductsWithTransactions()
            ->map(function ($product) {
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
                    'stock' => $stok,
                    'minimum_stock' => $product->minimum_stock,
                ];
            })
            ->filter(fn($item) => $item['stock'] < $item['minimum_stock'])
            ->sortBy('stock')
            ->values();

        $transaksiMasuk = $this->repo->countTransactionsSince('Masuk', $startDate);
        $transaksiKeluar = $this->repo->countTransactionsSince('Keluar', $startDate);

        $jumlahProduk = null;
        $aktivitasPengguna = collect();
        $barangMasukPending = collect();
        $barangKeluarPending = collect();

        if ($role === 'admin') {
            $jumlahProduk = $this->repo->countProducts();
            $aktivitasPengguna = $this->activityLog->getRecent(5);
        }

        if ($role === 'staff_gudang') {
            $barangMasukPending = $this->repo->pendingTransactions('Masuk');
            $barangKeluarPending = $this->repo->pendingTransactions('Keluar');
        }

        return compact(
            'jumlahProduk',
            'transaksiMasuk',
            'transaksiKeluar',
            'grafikStok',
            'aktivitasPengguna',
            'barangMasukPending',
            'barangKeluarPending',
            'role'
        );
    }
}
