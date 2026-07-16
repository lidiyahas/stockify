<?php

namespace App\Services;

interface UserService
{
    public function getAll();
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete($user);
}
