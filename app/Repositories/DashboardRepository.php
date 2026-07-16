<?php

namespace App\Repositories;

interface DashboardRepository
{
    public function getProductsWithTransactions();
    public function countProducts(): int;
    public function countTransactionsSince(string $type, $sinceDate): int;
    public function recentUsers(int $limit = 5);
    public function pendingTransactions(string $type);
}
