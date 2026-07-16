<?php

namespace App\Repositories\Impl;

use App\Repositories\ProductRepository;
use App\Models\Product;

class ProductRepositoryImpl implements ProductRepository
{
    public function paginate(int $perPage = 10)
    {
        return Product::with(['category', 'supplier'])->latest()->paginate($perPage);
    }

    public function all()
    {
        return Product::all();
    }

    public function find(int $id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($product, array $data)
    {
        $product->update($data);
        return $product;
    }

    public function delete($product)
    {
        return $product->delete();
    }
}
