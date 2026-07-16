<?php

namespace App\Repositories;

interface SupplierRepository
{
    public function all();
    public function create(array $data);
    public function update($supplier, array $data);
    public function delete($supplier);
}
