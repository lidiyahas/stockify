<?php

namespace App\Services\Impl;

use App\Services\ProductAttributeService;
use App\Repositories\ProductAttributeRepository;

class ProductAttributeServiceImpl implements ProductAttributeService
{
    private ProductAttributeRepository $repo;

    public function __construct(ProductAttributeRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getPaginated(int $perPage = 10)
    {
        return $this->repo->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->repo->find($id);
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function update(int $id, array $data)
    {
        $attribute = $this->repo->find($id);
        return $this->repo->update($attribute, $data);
    }

    public function delete(int $id)
    {
        $attribute = $this->repo->find($id);
        return $this->repo->delete($attribute);
    }
}
