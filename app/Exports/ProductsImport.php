<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Cari category_id & supplier_id berdasarkan nama (biar import gampang, gak perlu tau ID)
        $category = Category::where('name', $row['kategori'])->first();
        $supplier = Supplier::where('name', $row['supplier'])->first();

        return new Product([
            'name'            => $row['nama_produk'],
            'sku'             => $row['sku'] ?? null,
            'category_id'     => $category->id ?? null,
            'supplier_id'     => $supplier->id ?? null,
            'description'     => $row['deskripsi'] ?? null,
            'purchase_price'  => $row['harga_beli'],
            'selling_price'   => $row['harga_jual'],
            'minimum_stock'   => $row['stok_minimum'] ?? 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_produk'  => 'required|string|max:255',
            'harga_beli'   => 'required|numeric|min:0',
            'harga_jual'   => 'required|numeric|min:0',
        ];
    }
}