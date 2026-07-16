<?php

namespace App\Repositories;

interface UserRepository
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update($user, array $data);
    public function delete($user);
}
