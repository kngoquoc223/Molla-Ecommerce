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
            $table->dropForeign('product_attr_product_id_foreign');
            $table->dropForeign('product_attr_attr_value_id_foreign');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('attr_value_id')->references('id')->on('attributes_values')->onDelete('cascade');
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
