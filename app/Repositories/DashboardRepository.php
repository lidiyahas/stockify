<?php

namespace App\Repositories;

interface DashboardRepository
{
    public function getProductsWithTransactions();
    public function countProducts(): int;
    public function countTransactionsInRange(string $type, $startDate, $endDate): int;
    public function recentUsers(int $limit = 5);
    public function pendingTransactions(string $type);
}
