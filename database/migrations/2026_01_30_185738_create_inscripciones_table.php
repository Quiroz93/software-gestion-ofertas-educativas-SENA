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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('programa_id')->constrained('programas')->onDelete('cascade');
            $table->foreignId('instructor_id')->nullable()->constrained('instructores')->onDelete('set null');
            $table->date('fecha_inscripcion');
            $table->date('fecha_retiro')->nullable();
            $table->enum('estado', ['activo', 'inactivo', 'retirado', 'finalizado'])->default('activo');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            // Índices únicos para evitar inscripciones duplicadas
            $table->unique(['user_id', 'programa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
