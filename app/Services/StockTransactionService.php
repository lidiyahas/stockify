<?php

namespace App\Services;

interface StockTransactionService
{
    public function getAll();
    public function create(array $data, $userId);
    public function update(int $transactionId, array $data);
    public function getEditableTransaction(int $transactionId);
}
