@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
         Edit Transaksi Stok
    </h2>

    {{-- Error Validation --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-5 shadow">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Form Edit Transaksi --}}
    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow w-full md:w-1/2">
        @csrf
        @method('PUT')

        {{-- Pilih Produk --}}
        <div class="mb-5">
            <label for="product_id" class="block mb-2 font-semibold text-gray-700">Produk</label>
            <select name="product_id" id="product_id" class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="">-- Pilih Produk --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id', $transaction->product_id) == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jenis Transaksi --}}
        <div class="mb-5">
            <label class="block mb-2 font-semibold text-gray-700">Jenis</label>
            <select name="type" id="type" class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500" required>
                <option value="Masuk" {{ old('type', $transaction->type) == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                <option value="Keluar" {{ old('type', $transaction->type) == 'Keluar' ? 'selected' : '' }}>Keluar</option>
            </select>
            @error('type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jumlah --}}
        <div class="mb-5">
            <label class="block mb-2 font-semibold text-gray-700">Jumlah</label>
            <input type="number" name="quantity" class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500" value="{{ old('quantity', $transaction->quantity) }}" min="1" required>
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
            <textarea name="notes" rows="3" class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500">{{ old('notes', $transaction->notes) }}</textarea>
            @error('notes')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="flex items-center gap-3">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 shadow">
                Simpan Perubahan
            </button>
            <a href="{{ route('transactions.index') }}" class="text-gray-600 hover:underline">Batal</a>
        </div>
    </form>
</div>

<script>
    const statusOptions = {
        Masuk: [
            { value: 'Diterima', label: 'Diterima' },
            { value: 'Ditolak', label: 'Ditolak' },
        ],
        Keluar: [
            { value: 'Dikeluarkan', label: 'Dikeluarkan' },
            { value: 'Ditolak', label: 'Ditolak' },
        ],
    };

    const typeSelect = document.getElementById('type');
    const statusSelect = document.getElementById('status');
    const oldType = "{{ old('type', $transaction->type) }}";
    const oldStatus = "{{ old('status', $transaction->status) }}";

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

    // Render awal dengan data transaksi yang sedang diedit
    renderStatusOptions(oldType, oldStatus);

    // Update ulang tiap kali Jenis diganti
    typeSelect.addEventListener('change', function () {
        renderStatusOptions(this.value);
    });
</script>
@endsection