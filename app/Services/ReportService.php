<?php

namespace App\Services;

interface ReportService
{
    public function getDashboardActivity(string $role);
    public function getTransactionReport(?string $startDate, ?string $endDate, ?int $categoryId);
    public function getStockReport(?int $categoryId, ?string $startDate, ?string $endDate);
}
