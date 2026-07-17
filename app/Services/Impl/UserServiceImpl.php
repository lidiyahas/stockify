<?php

namespace App\Services\Impl;

use App\Services\UserService;
use App\Services\ActivityLogService;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserServiceImpl implements UserService
{
    private UserRepository $repo;
    private ActivityLogService $activityLog;

    public function __construct(UserRepository $repo, ActivityLogService $activityLog)
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
        $user = $this->repo->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ]);

        $this->activityLog->log('create', "Menambahkan pengguna '{$user->name}' (role: {$user->role})", 'User', $user->id);

        return $user;
    }

    public function update(int $id, array $data)
    {
        $user = $this->repo->find($id);

        $this->repo->update($user, [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
        ]);

        $this->activityLog->log('update', "Mengubah data pengguna '{$user->name}'", 'User', $user->id);

        return $user;
    }

    public function delete($user)
    {
        $name = $user->name;
        $id = $user->id;

        $result = $this->repo->delete($user);

        $this->activityLog->log('delete', "Menghapus pengguna '{$name}'", 'User', $id);

        return $result;
    }
}
