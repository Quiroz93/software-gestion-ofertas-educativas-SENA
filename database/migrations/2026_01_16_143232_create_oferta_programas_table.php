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
        Schema::create('oferta_programas', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('oferta_id');
    $table->unsignedBigInteger('programa_id');
    $table->timestamps();

    $table->foreign('oferta_id')->references('id')->on('ofertas')->onDelete('cascade');
    $table->foreign('programa_id')->references('id')->on('programas')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oferta_programas');
    }
};
