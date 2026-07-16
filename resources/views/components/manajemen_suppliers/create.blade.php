@extends('layouts.dashboard')

@section('content')
<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Tambah Supplier</h2>
    <form method="POST" action="{{ route('suppliers.store') }}">
        @csrf
        <div class="mb-4">
            <label>Nama:</label>
            <input type="text" name="name" class="w-full border p-2" required>
        </div>
        <div class="mb-4">
            <label>Alamat:</label>
            <textarea name="address" class="w-full border p-2" required></textarea>
        </div>
        <div class="mb-4">
            <label>Telepon:</label>
            <input type="text" name="phone" class="w-full border p-2" required>
        </div>
        <div class="mb-4">
            <label>Email:</label>
            <input type="email" name="email" class="w-full border p-2" required>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection