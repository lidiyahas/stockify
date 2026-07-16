<?php

namespace App\Repositories;

interface StockTransactionRepository
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update($transaction, array $data);
    public function sumQuantity(int $productId, string $type, string $status, ?int $excludeId = null): int;
}
