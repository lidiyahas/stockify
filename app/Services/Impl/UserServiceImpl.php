<?php

namespace App\Services\Impl;

use App\Services\UserService;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserServiceImpl implements UserService
{
    private UserRepository $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function create(array $data)
    {
        return $this->repo->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function update(int $id, array $data)
    {
        $user = $this->repo->find($id);

        return $this->repo->update($user, [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
        ]);
    }

    public function delete($user)
    {
        return $this->repo->delete($user);
    }
}
