<?php

namespace App\Services\Impl;

use App\Services\ProductService;
use App\Services\ActivityLogService;
use App\Repositories\ProductRepository;
use App\Repositories\StockTransactionRepository;

class ProductServiceImpl implements ProductService
{
    private ProductRepository $repo;
    private ActivityLogService $activityLog;
    private StockTransactionRepository $transactionRepo;

    public function __construct(ProductRepository $repo, ActivityLogService $activityLog, StockTransactionRepository $transactionRepo)
    {
        $this->repo = $repo;
        $this->activityLog = $activityLog;
        $this->transactionRepo = $transactionRepo;
    }

    public function getPaginated(int $perPage = 10)
    {
        return $this->repo->paginate($perPage);
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function create(array $data)
    {
        $product = $this->repo->create($data);

        $this->activityLog->log('create', "Menambahkan produk '{$product->name}'", 'Product', $product->id);

        return $product;
    }

    public function update($product, array $data)
    {
        $this->repo->update($product, $data);

        $this->activityLog->log('update', "Mengubah produk '{$product->name}'", 'Product', $product->id);

        return $product;
    }

    public function delete($product)
    {
        $name = $product->name;
        $id = $product->id;

        $result = $this->repo->delete($product);

        $this->activityLog->log('delete', "Menghapus produk '{$name}'", 'Product', $id);

        return $result;
    }

    public function getDetail($product): array
    {
        $product->loadMissing(['category', 'supplier', 'attributes']);

        $totalMasuk = $this->transactionRepo->sumQuantity($product->id, 'Masuk', 'Diterima');
        $totalKeluar = $this->transactionRepo->sumQuantity($product->id, 'Keluar', 'Dikeluarkan');
        $stokSaatIni = $totalMasuk - $totalKeluar;

        $riwayatTransaksi = $product->transactions()
            ->with('user')
            ->latest('date')
            ->take(10)
            ->get();

        return [
            'product' => $product,
            'stokSaatIni' => $stokSaatIni,
            'riwayatTransaksi' => $riwayatTransaksi,
        ];
    }
}
