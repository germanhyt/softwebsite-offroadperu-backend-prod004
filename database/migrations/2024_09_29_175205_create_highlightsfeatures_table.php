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
        Schema::create('highlightsfeatures', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_highlight')->nullable();
            $table->foreign('id_highlight')
                ->references('id')
                ->on('highlights')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_feature')->nullable();
            $table->foreign('id_feature')
                ->references('id')
                ->on('features')
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
        Schema::dropIfExists('highlightsfeatures');
    }
};
