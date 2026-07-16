<?php

namespace App\Repositories;

interface ProductRepository
{
    public function paginate(int $perPage = 10);
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update($product, array $data);
    public function delete($product);
}
