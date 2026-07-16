<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Supplier extends Model
{
    protected $fillable = ['name', 'address', 'phone', 'email'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
