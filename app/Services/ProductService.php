<?php

namespace App\Services;

interface ProductService
{
    public function getPaginated(int $perPage = 10);
    public function getAll();
    public function create(array $data);
    public function update($product, array $data);
    public function delete($product);
    public function getDetail($product): array;
}
