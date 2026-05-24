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

        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->longText('description')->nullable();
                $table->unsignedBigInteger('id_typevehicle')->nullable();
                $table->foreign('id_typevehicle')
                    ->references('id')
                    ->on('typevehicles')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                $table->unsignedBigInteger('id_brand')->nullable();
                $table->foreign('id_brand')
                    ->references('id')
                    ->on('brands')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                // $table->unsignedBigInteger('id_category')->nullable();
                // $table->foreign('id_category')
                //     ->references('id')
                //     ->on('categories')
                //     ->onDelete('cascade')
                //     ->onUpdate('cascade');
                // $table->unsignedBigInteger('id_subcategory')->nullable();
                // $table->foreign('id_subcategory')
                //     ->references('id')
                //     ->on('subcategories')
                //     ->onDelete('cascade')
                //     ->onUpdate('cascade');
                $table->unsignedBigInteger('id_brandvehicle')->nullable();
                $table->foreign('id_brandvehicle')
                    ->references('id')
                    ->on('brandvehicles')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                // $table->unsignedBigInteger('id_modell')->nullable();
                // $table->foreign('id_modell')
                //     ->references('id')
                //     ->on('modells')
                //     ->onDelete('cascade')
                //     ->onUpdate('cascade');
                $table->unsignedBigInteger('id_generaldescription')->nullable();
                $table->foreign('id_generaldescription')
                    ->references('id')
                    ->on('generaldescriptions')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->integer('stock')->nullable();
                $table->decimal('price', 8, 2)->nullable();
                $table->decimal('discount', 8, 2)->nullable();
                $table->string('img');

                // $table->integer('year_start')->nullable();
                // $table->integer('year_end')->nullable();

                // $table->string('lift')->nullable();
                $table->string('from_lift')->nullable();
                $table->string('rear_lift')->nullable();
                $table->integer('most_requested')->default(0);
                $table->integer('trend')->default(0);

                $table->integer('state')->default(1);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
