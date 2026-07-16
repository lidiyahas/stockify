@extends('layouts.dashboard')

@section('content')
    <div class="p-4">
        <h2 class="text-xl font-bold mb-4">Tambah Pengguna</h2>
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="mb-4">
                <label>Nama:</label>
                <input type="text" name="name" class="w-full border p-2" required>
            </div>
            <div class="mb-4">
                <label>Email:</label>
                <input type="email" name="email" class="w-full border p-2" required>
            </div>
            <div class="mb-4">
                <label>Password:</label>
                <input type="password" name="password" class="w-full border p-2" required>
            </div>
            <div class="mb-4">
                <label>Role:</label>
                <select name="role" class="w-full border p-2" required>
                    <option value="admin">Admin</option>
                    <option value="manajer_gudang">Manajer Gudang</option>
                    <option value="staff_gudang">Staff Gudang</option>
                </select>
            </div>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
@endsection