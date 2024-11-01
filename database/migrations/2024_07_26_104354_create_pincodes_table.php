<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pincodes', function (Blueprint $table) {
            $table->id();
            $table->string('state');
            $table->string('district');
            $table->string('city');
            $table->string('pincode');
            $table->boolean('isDeliverable')->default(true);
            $table->string('charges')->default(0);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pincodes');
    }
};
