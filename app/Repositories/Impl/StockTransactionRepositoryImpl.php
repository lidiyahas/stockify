<?php

namespace App\Repositories\Impl;

use App\Repositories\StockTransactionRepository;
use App\Models\StockTransaction;

class StockTransactionRepositoryImpl implements StockTransactionRepository
{
    public function all()
    {
        return StockTransaction::with('product','user')->orderBy('id','desc')->get();
    }

    public function create(array $data)
    {
        return StockTransaction::create($data);
    }
}
