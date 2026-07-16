<?php

namespace App\Repositories;

interface ProductAttributeRepository
{
    public function paginate(int $perPage = 10);
    public function find(int $id);
    public function create(array $data);
    public function update($attribute, array $data);
    public function delete($attribute);
}
