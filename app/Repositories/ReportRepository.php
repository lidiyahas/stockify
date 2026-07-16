<?php

namespace App\Repositories;

interface ReportRepository
{
    public function filteredTransactions(?string $startDate, ?string $endDate, ?int $categoryId);
    public function productsWithTransactions(?int $categoryId, ?string $startDate, ?string $endDate);
    public function recentUsers(int $limit = 5);
}
