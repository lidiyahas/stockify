<?php

namespace App\Repositories\Impl;

use App\Repositories\CategoryRepository;
use App\Models\Category;

class CategoryRepositoryImpl implements CategoryRepository
{
    public function all()
    {
        return Category::latest()->get();
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update($category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function delete($category)
    {
        return $category->delete();
    }
}
