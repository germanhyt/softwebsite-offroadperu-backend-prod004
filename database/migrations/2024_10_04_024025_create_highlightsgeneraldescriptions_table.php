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
        Schema::create('highlightsgeneraldescriptions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_highlight')->nullable();
            $table->foreign('id_highlight')
                ->references('id')
                ->on('highlights')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('id_generaldescription')->nullable();
            $table->foreign('id_generaldescription')
                ->references('id')
                ->on('generaldescriptions')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('state')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('highlightsgeneraldescriptions');
    }
};
