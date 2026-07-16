<?php

namespace App\Services;

interface StockOpnameService
{
    public function getProducts();
    public function applyOpname(array $products, $userId): void;
}
