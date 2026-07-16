<?php

namespace App\Services;

use App\Http\Repositories\DashboardRepository;

class DashboardService
{
    protected DashboardRepository $repo;

    public function __construct(DashboardRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getDashboardData(): array
    {
        // Ambil ringkasan statistik
        $counts = $this->repo->getCounts();

        // Total stok
        $totalStock = $this->repo->getTotalStock();

        // Produk dengan stok terendah (5)
        $lowStock = $this->repo->getLowStockProducts(5);

        // Stok per kategori untuk chart
        $stockPerCategory = $this->repo->getStockPerCategory();

        // Transaksi bulanan untuk 12 bulan terakhir
        $monthlyTransactions = $this->repo->getMonthlyTransactions(12);

        // Recent user activities (jika tabel logs ada)
        $recentActivities = $this->repo->getRecentActivities(10);

        return [
            'counts' => $counts,
            'totalStock' => $totalStock,
            'lowStock' => $lowStock,
            'stockPerCategory' => $stockPerCategory,
            'monthlyTransactions' => $monthlyTransactions,
            'recentActivities' => $recentActivities,
        ];
    }
}