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
        Schema::create('exportaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('tipo'); // 'preinscritos', etc
            $table->json('filtros_aplicados')->nullable(); // JSON con filtros usados
            $table->integer('total_registros')->default(0);
            $table->string('nombre_archivo');
            $table->string('ruta_archivo')->nullable(); // Ruta de almacenamiento
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('tipo');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exportaciones');
    }
};
