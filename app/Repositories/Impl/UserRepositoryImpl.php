<?php

namespace App\Repositories\Impl;

use App\Repositories\UserRepository;
use App\Models\User;

class UserRepositoryImpl implements UserRepository
{
    public function all()
    {
        return User::all();
    }

    public function find(int $id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete($user)
    {
        return $user->delete();
    }
}
