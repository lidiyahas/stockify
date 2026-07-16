<?php

namespace App\Repositories\Impl;

use App\Repositories\SupplierRepository;
use App\Models\Supplier;

class SupplierRepositoryImpl implements SupplierRepository
{
    public function all()
    {
        return Supplier::all();
    }

    public function create(array $data)
    {
        return Supplier::create($data);
    }

    public function update($supplier, array $data)
    {
        $supplier->update($data);
        return $supplier;
    }

    public function delete($supplier)
    {
        return $supplier->delete();
    }
}
