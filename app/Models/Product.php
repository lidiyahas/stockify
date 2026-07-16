<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   
    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'sku',
        'description',
        'purchase_price',
        'selling_price',
        'image',
        'minimum_stock',
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function transactions()
    {
        return $this->hasMany(\App\Models\StockTransaction::class);
    }

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

}
