<?php

namespace App\Repositories\Impl;

use App\Repositories\DashboardRepository;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;

class DashboardRepositoryImpl implements DashboardRepository
{
    public function getProductsWithTransactions()
    {
        return Product::with(['category', 'transactions' => function ($q) {
            $q->select('product_id', 'type', 'quantity', 'status');
        }])->get();
    }

    public function countProducts(): int
    {
        return Product::count();
    }

    public function countTransactionsInRange(string $type, $startDate, $endDate): int
    {
        return StockTransaction::where('type', $type)
            ->whereBetween('date', [$startDate, $endDate])
            ->count();
    }

    public function recentUsers(int $limit = 5)
    {
        return User::orderBy('updated_at', 'desc')->take($limit)->get();
    }

    public function pendingTransactions(string $type)
    {
        return StockTransaction::with('product')
            ->where('type', $type)
            ->where('status', 'Pending')
            ->latest()
            ->get();
    }
}
