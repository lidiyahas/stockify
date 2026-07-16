<?php

namespace App\Repositories\Impl;

use App\Repositories\ReportRepository;
use App\Models\StockTransaction;
use App\Models\Product;
use App\Models\User;

class ReportRepositoryImpl implements ReportRepository
{
    public function filteredTransactions(?string $startDate, ?string $endDate, ?int $categoryId)
    {
        return StockTransaction::with(['product.category', 'user'])
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->whereHas('product', function ($q) use ($categoryId) {
                    $q->where('category_id', $categoryId);
                });
            })
            ->latest('date')
            ->get();
    }

    public function productsWithTransactions(?int $categoryId, ?string $startDate, ?string $endDate)
    {
        $query = Product::with(['category', 'transactions' => function ($q) use ($startDate, $endDate) {
            $q->select('id', 'product_id', 'type', 'quantity', 'status', 'date');

            if ($startDate && $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            }
        }]);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return $query->get();
    }

    public function recentUsers(int $limit = 5)
    {
        return User::orderBy('updated_at', 'desc')->take($limit)->get();
    }
}
