@extends('layouts.dashboard')

@section('content')

<div class="p-6">

<h2 class="text-2xl font-bold mb-5">

Dashboard Staff Gudang

</h2>

<h3 class="text-xl font-semibold mb-4">

Daftar Transaksi Pending

</h3>

<table class="min-w-full border">

<thead>

<tr>

<th>No</th>
<th>Produk</th>
<th>Jenis</th>
<th>Jumlah</th>
<th>Status</th>

</tr>

</thead>

<tbody>

@forelse($pendingTransactions as $transaction)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $transaction->product->name }}</td>

<td>{{ $transaction->type }}</td>

<td>{{ $transaction->quantity }}</td>

<td>

<span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">

{{ $transaction->status }}

</span>

</td>

</tr>

@empty

<tr>

<td colspan="5">

Tidak ada transaksi Pending

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@endsection