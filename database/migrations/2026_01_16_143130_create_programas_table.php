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
            $table->string('modalidad')->nullable();
            $table->string('jornada')->nullable();
            $table->string('titulo_otorgado')->nullable();
            $table->string('codigo_snies')->nullable();
            $table->string('registro_calidad')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->date('fecha_actualizacion')->nullable();
            $table->string('estado')->nullable();
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('centro_id')->nullable();
            $table->integer('cupos')->nullable();
            $table->timestamps();

            $table->foreign('red_id')->references('id')->on('redes')->onDelete('cascade');
            $table->foreign('nivel_formacion_id')->references('id')->on('nivel_formaciones')->onDelete('cascade');
            $table->foreign('centro_id')->references('id')->on('centros')->onDelete('set null');
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
