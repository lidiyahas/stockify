<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;

        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                abort(403, 'Akses ditolak. Anda tidak memiliki hak akses.');
            }
            return $next($request);
        })->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $users = $this->service->getAll();
        return view('components.manajemen_pengguna.index', compact('users'));
    }

    public function create()
    {
        return view('components.manajemen_pengguna.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|in:admin,manajer_gudang,staff_gudang',
            'password' => 'required|string|min:8',
        ]);

        $this->service->create($validated);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('components.manajemen_pengguna.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string|in:admin,manajer_gudang,staff_gudang',
        ]);

        $this->service->update($id, $validated);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->service->delete($user);
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
