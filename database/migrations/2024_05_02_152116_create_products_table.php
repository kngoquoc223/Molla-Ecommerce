<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('brand_id');
            $table->string('description')->nullable();
            $table->string('content')->nullable();
            $table->integer('category_id');
            $table->string('price')->nullable();
            $table->string('img')->nullable();
            $table->integer('publish')->default(0);
            $table->string('discount')->nullable();
            $table->string('thumb');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
