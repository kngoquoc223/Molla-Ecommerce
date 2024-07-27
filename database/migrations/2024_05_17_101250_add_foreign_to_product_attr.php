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
        Schema::table('product_attr', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('attr_value_id')->references('id')->on('attributes_values');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_attr', function (Blueprint $table) {
            //
        });
    }
};
