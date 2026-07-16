<?php

namespace App\Services\Impl;

use App\Services\ReportService;
use App\Repositories\ReportRepository;

class ReportServiceImpl implements ReportService
{
    private ReportRepository $repo;

    public function __construct(ReportRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getDashboardActivity(string $role)
    {
        if ($role === 'admin') {
            return $this->repo->recentUsers(5);
        }

        return collect();
    }

    public function getTransactionReport(?string $startDate, ?string $endDate, ?int $categoryId)
    {
        return $this->repo->filteredTransactions($startDate, $endDate, $categoryId);
    }

    public function getStockReport(?int $categoryId, ?string $startDate, ?string $endDate)
    {
        $products = $this->repo->productsWithTransactions($categoryId, $startDate, $endDate);

        return $products->map(function ($product) {
            $finalStock = $product->transactions->reduce(function ($carry, $trx) {
                if ($trx->type === 'Masuk' && $trx->status === 'Diterima') {
                    return $carry + $trx->quantity;
                }
                if ($trx->type === 'Keluar' && $trx->status === 'Dikeluarkan') {
                    return $carry - $trx->quantity;
                }
                return $carry;
            }, 0);

            $product->final_stock = $finalStock;
            return $product;
        });
    }
}
