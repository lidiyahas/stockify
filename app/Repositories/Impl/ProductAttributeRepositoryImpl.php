<?php

namespace App\Repositories\Impl;

use App\Repositories\ProductAttributeRepository;
use App\Models\ProductAttribute;

class ProductAttributeRepositoryImpl implements ProductAttributeRepository
{
    public function paginate(int $perPage = 10)
    {
        return ProductAttribute::with('product')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function find(int $id)
    {
        return ProductAttribute::findOrFail($id);
    }

    public function create(array $data)
    {
        return ProductAttribute::create($data);
    }

    public function update($attribute, array $data)
    {
        $attribute->update($data);
        return $attribute;
    }

    public function delete($attribute)
    {
        return $attribute->delete();
    }
}
