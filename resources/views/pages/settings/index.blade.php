@extends('layouts.dashboard')

@section('content')
<div class="p-6 max-w-xl mx-auto bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Pengaturan Aplikasi</h2>

    {{-- Form untuk update nama dan logo --}}
    <form action="{{ route('settings.preview') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-5">
            <label for="app_name" class="block font-semibold mb-2 text-gray-700">Nama Aplikasi</label>
            <input 
                type="text" 
                id="app_name" 
                name="app_name" 
                value="{{ old('app_name', $app_name) }}" 
                class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Masukkan nama aplikasi"
            >
            @error('app_name')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="logo" class="block font-semibold mb-2 text-gray-700">Logo</label>

            {{-- Tampilkan preview logo --}}
            <div class="mb-3">
                <img 
                    src="{{ $app_logo }}" 
                    alt="Logo" 
                    class="h-20 object-contain border rounded"
                    onerror="this.src='/images/default-logo.png';"
                >
            </div>

            <input 
                type="file" 
                id="logo" 
                name="logo" 
                accept="image/*"
                class="border border-gray-300 rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            @error('logo')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button 
            type="submit" 
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded transition duration-300"
        >
            Submit
        </button>
    </form>
</div>
@endsection
