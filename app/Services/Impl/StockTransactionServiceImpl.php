<?php

namespace App\Services\Impl;

use App\Services\StockTransactionService;
use App\Repositories\StockTransactionRepository;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class StockTransactionServiceImpl implements StockTransactionService
{
    private $repo;

    public function __construct(StockTransactionRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function create(array $data, $userId)
    {
        return DB::transaction(function () use ($data, $userId) {
            $product = Product::findOrFail($data['product_id']);

            if ($data['type'] === 'Masuk') {
                $product->stock += $data['quantity'];
            } else {
                if ($product->stock < $data['quantity']) {
                    throw new \Exception('Stok tidak cukup');
                }
                $product->stock -= $data['quantity'];
            }
            $product->save();

            return $this->repo->create([
                'product_id' => $data['product_id'],
                'user_id' => $userId,
                'type' => $data['type'],
                'quantity' => $data['quantity'],
                'status' => $data['status'],
                'notes' => $data['notes'] ?? null,
                'date' => now()
            ]);
        });
    }

    public function stockOpname()
    {
        return Product::select('id','name','stock','minimum_stock')->get();
    }
}
