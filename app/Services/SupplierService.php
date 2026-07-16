<?php

namespace App\Services;

interface SupplierService
{
    public function getAll();
    public function create(array $data);
    public function update($supplier, array $data);
    public function delete($supplier);
}
