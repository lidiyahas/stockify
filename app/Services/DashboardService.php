<?php

namespace App\Services;

interface DashboardService
{
    public function getDashboardData(string $role, ?string $startDate = null, ?string $endDate = null): array;
}
