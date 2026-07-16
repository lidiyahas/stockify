<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id(); // id int [pk, increment]
            $table->string('name'); // name varchar
            $table->text('address')->nullable(); // address text nullable
            $table->string('phone')->nullable(); // phone varchar nullable
            $table->string('email')->nullable(); // email varchar nullable
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
