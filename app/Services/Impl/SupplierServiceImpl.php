<?php

namespace App\Services\Impl;

use App\Services\SupplierService;
use App\Repositories\SupplierRepository;

class SupplierServiceImpl implements SupplierService
{
    private SupplierRepository $repo;

    public function __construct(SupplierRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function update($supplier, array $data)
    {
        return $this->repo->update($supplier, $data);
    }

    public function delete($supplier)
    {
        return $this->repo->delete($supplier);
    }
}
