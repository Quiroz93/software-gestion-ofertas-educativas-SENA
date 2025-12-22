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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            // Información principal de la oferta
            $table->string('denominacion');          // Nombre o título de la oferta
            $table->string('nivel_formacion');       // Nivel de formación
            $table->string('modalidad');             // Modalidad (virtual, presencial, mixta)
            $table->string('jornada');               // Jornada (mañana, tarde, noche)
            $table->string('red_tecnologica');       // Red tecnológica
            $table->string('anio_lectivo');          // Año lectivo
            $table->date('fecha');                   // Fecha de publicación o inicio
            $table->string('codigo_programa');       // Código del programa
            $table->integer('cupos')->nullable();    // Número de cupos disponibles
            $table->text('descripcion')->nullable(); // Descripción de la oferta
            $table->boolean('estado')->default(true); // Estado (activo/inactivo)
            $table->unsignedBigInteger('centro_id');
            $table->foreign('centro_id')->references('id')->on('centros')
                ->nullable()->cascadeOnDelete(); // Centro asociado a la oferta (clave foránea)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
