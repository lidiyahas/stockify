<?php

namespace App\Services;

interface DashboardService
{
    public function getDashboardData(string $role): array;
}
