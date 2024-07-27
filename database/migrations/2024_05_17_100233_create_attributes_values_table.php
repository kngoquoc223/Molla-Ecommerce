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
        Schema::create('attributes_values', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_attribute')->unsigned();
            $table->timestamp('deleted_at')->nullable();
            $table->string('value');
            $table->integer('publish');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes_values');
    }
};
