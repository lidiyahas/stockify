<?php

namespace App\Services\Impl;

use App\Services\ProductService;
use App\Repositories\ProductRepository;

class ProductServiceImpl implements ProductService
{
    private ProductRepository $repo;

    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
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
        return $this->repo->create($data);
    }

    public function update($product, array $data)
    {
        return $this->repo->update($product, $data);
    }

    public function delete($product)
    {
        return $this->repo->delete($product);
    }
}
