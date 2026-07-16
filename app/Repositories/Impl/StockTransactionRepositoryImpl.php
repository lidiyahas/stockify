<?php

namespace App\Repositories\Impl;

use App\Repositories\StockTransactionRepository;
use App\Models\StockTransaction;

class StockTransactionRepositoryImpl implements StockTransactionRepository
{
    public function all()
    {
        return StockTransaction::with('product', 'user')->latest()->get();
    }

    public function find(int $id)
    {
        return StockTransaction::findOrFail($id);
    }

    public function create(array $data)
    {
        return StockTransaction::create($data);
    }

    public function update($transaction, array $data)
    {
        $transaction->update($data);
        return $transaction;
    }

    public function sumQuantity(int $productId, string $type, string $status, ?int $excludeId = null): int
    {
        $query = StockTransaction::where('product_id', $productId)
            ->where('type', $type)
            ->where('status', $status);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return (int) $query->sum('quantity');
    }
}
