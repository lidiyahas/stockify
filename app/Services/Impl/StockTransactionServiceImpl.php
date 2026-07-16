<?php

namespace App\Services\Impl;

use App\Services\StockTransactionService;
use App\Repositories\StockTransactionRepository;
use Illuminate\Support\Facades\DB;

class StockTransactionServiceImpl implements StockTransactionService
{
    private StockTransactionRepository $repo;

    public function __construct(StockTransactionRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function create(array $data, $userId)
    {
        // Hitung stok tersedia dari transaksi yang sudah final
        $stokTersedia = $this->hitungStokTersedia($data['product_id']);

        if ($data['type'] === 'Keluar' && $data['quantity'] > $stokTersedia) {
            throw new \Exception("Stok tidak mencukupi. Stok yang tersedia hanya {$stokTersedia}.");
        }

        $data['user_id'] = $userId;
        $data['date'] = now();

        return $this->repo->create($data);
    }

    public function update(int $transactionId, array $data)
    {
        $transaction = $this->repo->find($transactionId);

        if ($transaction->status !== 'Pending') {
            throw new \Exception('Transaksi yang sudah diproses tidak bisa diedit.');
        }

        if ($data['type'] === 'Keluar' && $data['status'] === 'Dikeluarkan') {
            $stokTersedia = $this->hitungStokTersedia($data['product_id'], $transactionId);

            if ($data['quantity'] > $stokTersedia) {
                throw new \Exception("Stok tidak mencukupi. Stok yang tersedia hanya {$stokTersedia}.");
            }
        }

        return $this->repo->update($transaction, $data);
    }

    public function getEditableTransaction(int $transactionId)
    {
        $transaction = $this->repo->find($transactionId);

        if ($transaction->status !== 'Pending') {
            throw new \Exception('Transaksi yang sudah diproses tidak bisa diedit.');
        }

        return $transaction;
    }

    private function hitungStokTersedia(int $productId, ?int $excludeId = null): int
    {
        $totalMasuk = $this->repo->sumQuantity($productId, 'Masuk', 'Diterima', $excludeId);
        $totalKeluar = $this->repo->sumQuantity($productId, 'Keluar', 'Dikeluarkan', $excludeId);

        return $totalMasuk - $totalKeluar;
    }
}
