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
        Schema::create('historias_de_exitos', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->string('titulo');
    $table->text('descripcion')->nullable();
    $table->year('año');
    $table->string('correo');
    $table->unsignedBigInteger('programa_id');
    $table->timestamps();

    $table->foreign('programa_id')->references('id')->on('programas')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historia_exitos');
    }
};
