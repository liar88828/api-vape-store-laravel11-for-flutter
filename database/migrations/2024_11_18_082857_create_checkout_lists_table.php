<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('checkout_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_checkout');
            $table->unsignedBigInteger('id_product');
            $table->foreign('id_checkout')->references('id')->on('checkouts')->onDelete('cascade');
            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_lists');
    }
};
