<?php

namespace App\Services\Impl;

use App\Services\StockTransactionService;
use App\Services\ActivityLogService;
use App\Repositories\StockTransactionRepository;

class StockTransactionServiceImpl implements StockTransactionService
{
    private StockTransactionRepository $repo;
    private ActivityLogService $activityLog;

    public function __construct(StockTransactionRepository $repo, ActivityLogService $activityLog)
    {
        $this->repo = $repo;
        $this->activityLog = $activityLog;
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

        $transaction = $this->repo->create($data);

        $jenis = $data['type'] === 'Masuk' ? 'barang masuk' : 'barang keluar';
        $this->activityLog->log(
            'create',
            "Mencatat transaksi {$jenis} sebanyak {$data['quantity']} untuk produk #{$data['product_id']} (status: {$data['status']})",
            'StockTransaction',
            $transaction->id,
            $userId
        );

        return $transaction;
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

        $this->repo->update($transaction, $data);

        $this->logStatusChange($transaction, $data['status']);

        return $transaction;
    }

    public function getEditableTransaction(int $transactionId)
    {
        $transaction = $this->repo->find($transactionId);

        if ($transaction->status !== 'Pending') {
            throw new \Exception('Transaksi yang sudah diproses tidak bisa diedit.');
        }

        return $transaction;
    }

    private function logStatusChange($transaction, string $newStatus): void
    {
        if ($newStatus === 'Diterima') {
            $this->activityLog->log('approve', "Menyetujui transaksi barang masuk #{$transaction->id}", 'StockTransaction', $transaction->id);
        } elseif ($newStatus === 'Dikeluarkan') {
            $this->activityLog->log('approve', "Menyetujui transaksi barang keluar #{$transaction->id}", 'StockTransaction', $transaction->id);
        } elseif ($newStatus === 'Ditolak') {
            $this->activityLog->log('reject', "Menolak transaksi #{$transaction->id}", 'StockTransaction', $transaction->id);
        } else {
            $this->activityLog->log('update', "Mengubah transaksi #{$transaction->id}", 'StockTransaction', $transaction->id);
        }
    }

    private function hitungStokTersedia(int $productId, ?int $excludeId = null): int
    {
        $totalMasuk = $this->repo->sumQuantity($productId, 'Masuk', 'Diterima', $excludeId);
        $totalKeluar = $this->repo->sumQuantity($productId, 'Keluar', 'Dikeluarkan', $excludeId);

        return $totalMasuk - $totalKeluar;
    }
}
