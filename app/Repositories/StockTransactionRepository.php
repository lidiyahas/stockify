<?php

namespace App\Repositories;

interface StockTransactionRepository
{
    public function all();
    public function create(array $data);
}
