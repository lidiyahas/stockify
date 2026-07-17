<?php

namespace App\Services\Impl;

use App\Services\ReportService;
use App\Services\ActivityLogService;
use App\Repositories\ReportRepository;

class ReportServiceImpl implements ReportService
{
    private ReportRepository $repo;
    private ActivityLogService $activityLog;

    public function __construct(ReportRepository $repo, ActivityLogService $activityLog)
    {
        $this->repo = $repo;
        $this->activityLog = $activityLog;
    }

    public function getDashboardActivity(string $role)
    {
        if ($role === 'admin') {
            return $this->activityLog->getRecent(5);
        }

        return collect();
    }

    public function getActivityLog(int $perPage = 20, ?int $userId = null, ?string $subjectType = null)
    {
        return $this->activityLog->getPaginated($perPage, $userId, $subjectType);
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
