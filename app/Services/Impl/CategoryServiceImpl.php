<?php

namespace App\Services\Impl;

use App\Services\CategoryService;
use App\Services\ActivityLogService;
use App\Repositories\CategoryRepository;

class CategoryServiceImpl implements CategoryService
{
    private CategoryRepository $repo;
    private ActivityLogService $activityLog;

    public function __construct(CategoryRepository $repo, ActivityLogService $activityLog)
    {
        $this->repo = $repo;
        $this->activityLog = $activityLog;
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function create(array $data)
    {
        $category = $this->repo->create($data);

        $this->activityLog->log('create', "Menambahkan kategori '{$category->name}'", 'Category', $category->id);

        return $category;
    }

    public function update($category, array $data)
    {
        $this->repo->update($category, $data);

        $this->activityLog->log('update', "Mengubah kategori '{$category->name}'", 'Category', $category->id);

        return $category;
    }

    public function delete($category)
    {
        $name = $category->name;
        $id = $category->id;

        $result = $this->repo->delete($category);

        $this->activityLog->log('delete', "Menghapus kategori '{$name}'", 'Category', $id);

        return $result;
    }
}
