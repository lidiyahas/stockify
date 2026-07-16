<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('supplier_id');

            $table->string('name');
            $table->string('sku')->unique(); // Stock Keeping Unit
            $table->text('description')->nullable();

            $table->decimal('purchase_price', 15, 2);
            $table->decimal('selling_price', 15, 2);

            $table->string('image')->nullable(); // Path ke file gambar

            $table->integer('minimum_stock')->default(0);

            $table->timestamps();

            // Foreign keys (optional, tergantung struktur relasi)
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
