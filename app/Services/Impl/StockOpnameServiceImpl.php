<?php

namespace App\Services\Impl;

use App\Services\StockOpnameService;
use App\Services\ActivityLogService;
use App\Repositories\ProductRepository;
use App\Repositories\StockTransactionRepository;

class StockOpnameServiceImpl implements StockOpnameService
{
    private ProductRepository $productRepo;
    private StockTransactionRepository $transactionRepo;
    private ActivityLogService $activityLog;

    public function __construct(ProductRepository $productRepo, StockTransactionRepository $transactionRepo, ActivityLogService $activityLog)
    {
        $this->productRepo = $productRepo;
        $this->transactionRepo = $transactionRepo;
        $this->activityLog = $activityLog;
    }

    public function getProducts()
    {
        return $this->productRepo->all();
    }

    /**
     * $products format: [['id' => 1, 'stock' => 25], ...] (hasil hitung fisik dari user)
     */
    public function applyOpname(array $products, $userId): void
    {
        foreach ($products as $productData) {
            $product = $this->productRepo->find($productData['id']);

            $totalMasuk = $this->transactionRepo->sumQuantity($product->id, 'Masuk', 'Diterima');
            $totalKeluar = $this->transactionRepo->sumQuantity($product->id, 'Keluar', 'Dikeluarkan');
            $currentStock = $totalMasuk - $totalKeluar;

            $selisih = $productData['stock'] - $currentStock;

            if ($selisih != 0) {
                $transaction = $this->transactionRepo->create([
                    'product_id' => $product->id,
                    'type' => $selisih > 0 ? 'Masuk' : 'Keluar',
                    'quantity' => abs($selisih),
                    'status' => $selisih > 0 ? 'Diterima' : 'Dikeluarkan',
                    'notes' => 'Penyesuaian melalui stok opname',
                    'user_id' => $userId,
                    'date' => now(),
                ]);

                $arah = $selisih > 0 ? 'menambah' : 'mengurangi';
                $this->activityLog->log(
                    'opname',
                    "Stock opname: {$arah} stok produk '{$product->name}' sebanyak " . abs($selisih) . " (sistem: {$currentStock}, fisik: {$productData['stock']})",
                    'Product',
                    $product->id,
                    $userId
                );
            }
        }
    }
}
