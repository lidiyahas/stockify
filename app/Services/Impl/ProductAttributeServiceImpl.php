<?php

namespace App\Services\Impl;

use App\Services\ProductAttributeService;
use App\Services\ActivityLogService;
use App\Repositories\ProductAttributeRepository;

class ProductAttributeServiceImpl implements ProductAttributeService
{
    private ProductAttributeRepository $repo;
    private ActivityLogService $activityLog;

    public function __construct(ProductAttributeRepository $repo, ActivityLogService $activityLog)
    {
        $this->repo = $repo;
        $this->activityLog = $activityLog;
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
        $attribute = $this->repo->create($data);

        $this->activityLog->log('create', "Menambahkan atribut '{$attribute->name}' pada produk", 'ProductAttribute', $attribute->id);

        return $attribute;
    }

    public function update(int $id, array $data)
    {
        $attribute = $this->repo->find($id);
        $this->repo->update($attribute, $data);

        $this->activityLog->log('update', "Mengubah atribut '{$attribute->name}'", 'ProductAttribute', $attribute->id);

        return $attribute;
    }

    public function delete(int $id)
    {
        $attribute = $this->repo->find($id);
        $name = $attribute->name;

        $result = $this->repo->delete($attribute);

        $this->activityLog->log('delete', "Menghapus atribut '{$name}'", 'ProductAttribute', $id);

        return $result;
    }
}
