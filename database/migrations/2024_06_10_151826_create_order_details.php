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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('order_id');
            $table->BigInteger('product_id');
            $table->BigInteger('user_id');
            $table->string('product_name');
            $table->string('product_price');
            $table->string('product_coupon');
            $table->string('product_feeship');
            $table->integer('product_sales_qty');
            $table->string('order_code')->length(50);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
