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
        Schema::create('complementaryproducts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_product')->nullable();
            $table->foreign('id_product')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('id_complementaryproduct')->nullable();
            $table->foreign('id_complementaryproduct')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complementaryproducts');
    }
};
