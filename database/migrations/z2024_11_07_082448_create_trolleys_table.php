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
        Schema::create('trolleys', function (Blueprint $table) {
            $table->id();
            $table->integer('qty');

//            $table->unsignedBigInteger('favorite_id')->nullable();
            $table->unsignedBigInteger('id_checkout')->nullable();
            $table->unsignedBigInteger('id_product');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
//            $table->foreign('favorite_id')->references('id')->on('favorites')->onDelete('cascade');
            $table->foreign('id_checkout')->references('id')->on('checkouts')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trolleys');
    }
};
