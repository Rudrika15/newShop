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
            $table->bigInteger('catalogid');
            $table->string('main_image');
            $table->string('sku');
            $table->bigInteger('categoryid');
            $table->string('slug');
            $table->string('opening_stock');
            $table->string('color');
            $table->string('size');
            $table->string('image');
            $table->string('description');
            $table->string('base_price');
            $table->string('tax_price');
            $table->string('discount_price');
            $table->integer('mrp');
            $table->enum('is_active', ['yes', 'no']);
            $table->timestamps();
            $table->softDeletes();
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
