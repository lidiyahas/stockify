@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
         Tambah Transaksi Stok
    </h2>

    {{-- Error Validation --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-5 shadow">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Form Tambah Transaksi --}}
    <form action="{{ route('transactions.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow w-full md:w-1/2">
        @csrf
        
        {{-- Pilih Produk --}}
        <div class="mb-5">
            <label for="product_id" class="block mb-2 font-semibold text-gray-700">Produk</label>

            @if($products->isEmpty())
                <div class="bg-yellow-100 text-yellow-800 p-3 rounded mb-3">
                    ⚠ Tidak ada produk tersedia.
                    <a href="{{ route('products.create') }}" class="text-blue-600 underline font-semibold">Tambah Produk</a>
                </div>
            @else
                <select name="product_id" id="product_id" class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            @endif
        </div>

        {{-- Jenis Transaksi --}}
        <div class="mb-5">
            <label class="block mb-2 font-semibold text-gray-700">Jenis</label>
            <select name="type" id="type" class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="Masuk" {{ old('type') == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                <option value="Keluar" {{ old('type') == 'Keluar' ? 'selected' : '' }}>Keluar</option>
            </select>
            @error('type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jumlah --}}
        <div class="mb-5">
            <label class="block mb-2 font-semibold text-gray-700">Jumlah</label>
            <input type="number" name="quantity" class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500" value="{{ old('quantity') }}" min="1" required>
            @error('quantity')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Status --}}
        <div class="mb-5">
            <label class="block mb-2 font-semibold text-gray-700">Status</label>
            <select name="status" id="status" class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500" required>
                {{-- Opsi diisi otomatis lewat JS sesuai Jenis yang dipilih --}}
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Catatan --}}
        <div class="mb-5">
            <label class="block mb-2 font-semibold text-gray-700">Catatan</label>
            <textarea name="notes" rows="3" class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
            @error('notes')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="flex items-center gap-3">
            <button type="submit" 
                    class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 shadow
                           {{ $products->isEmpty() ? 'opacity-50 cursor-not-allowed' : '' }}"
                    {{ $products->isEmpty() ? 'disabled' : '' }}>
                 Simpan
            </button>
            <a href="{{ route('transactions.index') }}" class="text-gray-600 hover:underline">Batal</a>
        </div>
    </form>
</div>

<script>
    const statusOptions = {
        Masuk: [
            { value: 'Pending', label: 'Pending' },
            { value: 'Diterima', label: 'Diterima' },
            { value: 'Ditolak', label: 'Ditolak' },
        ],
        Keluar: [
            { value: 'Pending', label: 'Pending' },
            { value: 'Dikeluarkan', label: 'Dikeluarkan' },
            { value: 'Ditolak', label: 'Ditolak' },
        ],
    };

    const typeSelect = document.getElementById('type');
    const statusSelect = document.getElementById('status');
    const oldType = "{{ old('type', 'Masuk') }}";
    const oldStatus = "{{ old('status', '') }}";

    function renderStatusOptions(selectedType, selectedStatus = '') {
        statusSelect.innerHTML = '';
        statusOptions[selectedType].forEach(opt => {
            const option = document.createElement('option');
            option.value = opt.value;
            option.textContent = opt.label;
            if (opt.value === selectedStatus) {
                option.selected = true;
            }
            statusSelect.appendChild(option);
        });
    }

    // Render awal (misal habis submit gagal validasi, biar old value tetap kepilih)
    renderStatusOptions(oldType, oldStatus);

    // Update ulang tiap kali Jenis diganti
    typeSelect.addEventListener('change', function () {
        renderStatusOptions(this.value);
    });

</script>
@endsection