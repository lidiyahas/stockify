<?php

namespace App\Services\Impl;

use App\Services\SupplierService;
use App\Services\ActivityLogService;
use App\Repositories\SupplierRepository;

class SupplierServiceImpl implements SupplierService
{
    private SupplierRepository $repo;
    private ActivityLogService $activityLog;

    public function __construct(SupplierRepository $repo, ActivityLogService $activityLog)
    {
        $this->repo = $repo;
        $this->activityLog = $activityLog;
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function create(array $data)
    {
        $supplier = $this->repo->create($data);

        $this->activityLog->log('create', "Menambahkan supplier '{$supplier->name}'", 'Supplier', $supplier->id);

        return $supplier;
    }

    public function update($supplier, array $data)
    {
        $this->repo->update($supplier, $data);

        $this->activityLog->log('update', "Mengubah supplier '{$supplier->name}'", 'Supplier', $supplier->id);

        return $supplier;
    }

    public function delete($supplier)
    {
        $name = $supplier->name;
        $id = $supplier->id;

        $result = $this->repo->delete($supplier);

        $this->activityLog->log('delete', "Menghapus supplier '{$name}'", 'Supplier', $id);

        return $result;
    }
}
