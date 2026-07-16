<?php

namespace App\Services\Impl;

use App\Services\CategoryService;
use App\Repositories\CategoryRepository;

class CategoryServiceImpl implements CategoryService
{
    private CategoryRepository $repo;

    public function __construct(CategoryRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function update($category, array $data)
    {
        return $this->repo->update($category, $data);
    }

    public function delete($category)
    {
        return $this->repo->delete($category);
    }
}
