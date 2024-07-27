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
        Schema::table('products', function (Blueprint $table) {
            $table->dateTime('new')->nullable();
            $table->integer('trending')->default(0);
            $table->integer('hot')->default(0);
            $table->integer('view')->default(0);
            $table->integer('parent_category_id')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('new');
            $table->dropColumn('trending');
            $table->dropColumn('hot');
            $table->dropColumn('view');
            $table->dropColumn('parent_category_id');
        });
    }
};
