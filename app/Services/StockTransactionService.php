<?php

namespace App\Services;

interface StockTransactionService
{
    public function getAll();
    public function create(array $data, $userId);
    public function stockOpname();
}
