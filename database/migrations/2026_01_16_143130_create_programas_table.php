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
        Schema::create('programas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->text('requisitos')->nullable();
            $table->integer('duracion_meses')->nullable();
            $table->unsignedBigInteger('red_id');
            $table->unsignedBigInteger('nivel_formacion_id');
            $table->timestamps();

            $table->foreign('red_id')->references('id')->on('redes')->onDelete('cascade');
            $table->foreign('nivel_formacion_id')->references('id')->on('nivel_formaciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programas');
    }
};
