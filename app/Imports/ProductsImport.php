<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    /**
     * Format kolom Excel:
     * nama_produk, sku, kategori, supplier, deskripsi, harga_beli, harga_jual, stok_minimum
     *
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $category = Category::where('name', trim($row['kategori']))->first();
        $supplier = Supplier::where('name', trim($row['supplier']))->first();

        return new Product([
            'category_id'    => $category->id,
            'supplier_id'    => $supplier->id,
            'name'           => $row['nama_produk'],
            'sku'            => $row['sku'],
            'description'    => $row['deskripsi'] ?? null,
            'purchase_price' => $row['harga_beli'],
            'selling_price'  => $row['harga_jual'],
            'minimum_stock'  => $row['stok_minimum'] ?? 0,
        ]);
    }

    /**
     * Validasi tiap baris SEBELUM model() dipanggil.
     * kategori & supplier divalidasi berdasarkan nama (exists di tabel terkait),
     * jadi baris dengan nama kategori/supplier yang salah ketik akan otomatis
     * di-skip (masuk failures()), bukan bikin error SQL.
     */
    public function rules(): array
    {
        return [
            'nama_produk'  => 'required|string|max:255',
            'sku'          => 'required|string|max:255|unique:products,sku',
            'kategori'     => 'required|string|exists:categories,name',
            'supplier'     => 'required|string|exists:suppliers,name',
            'harga_beli'   => 'required|numeric|min:0',
            'harga_jual'   => 'required|numeric|min:0',
            'stok_minimum' => 'nullable|integer|min:0',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'kategori.exists' => 'Kategori ":input" tidak ditemukan di database.',
            'supplier.exists' => 'Supplier ":input" tidak ditemukan di database.',
            'sku.unique'       => 'SKU ":input" sudah digunakan produk lain.',
        ];
    }
}