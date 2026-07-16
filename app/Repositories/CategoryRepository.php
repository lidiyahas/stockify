<?php

namespace App\Repositories;

interface CategoryRepository
{
    public function all();
    public function create(array $data);
    public function update($category, array $data);
    public function delete($category);
}
