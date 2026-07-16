@extends('layouts.dashboard')

@section('content')
    <div class="p-4">
        <h2 class="text-xl font-bold mb-4">Edit Pengguna</h2>
        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf @method('PUT')
            <div class="mb-4">
                <label>Nama:</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full border p-2" required>
            </div>
            <div class="mb-4">
                <label>Email:</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full border p-2" required>
            </div>
            <div class="mb-4">
                <label>Role:</label>
                <select name="role" class="w-full border p-2" required>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="manajer_gudang" {{ $user->role === 'manajer_gudang' ? 'selected' : '' }}>Manajer Gudang</option>
                    <option value="staff_gudang" {{ $user->role === 'staff_gudang' ? 'selected' : '' }}>Staff Gudang</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
@endsection