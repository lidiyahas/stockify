<?php

namespace App\Services;

interface CategoryService
{
    public function getAll();
    public function create(array $data);
    public function update($category, array $data);
    public function delete($category);
}
