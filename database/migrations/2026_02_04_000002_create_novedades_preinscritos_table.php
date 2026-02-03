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
        Schema::create('novedades_preinscritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('preinscrito_id')->constrained('preinscritos')->cascadeOnDelete();
            $table->foreignId('tipo_novedad_id')->nullable()->constrained('tipos_novedad')->setNullOnDelete();
            $table->enum('estado', ['abierta', 'en_gestion', 'resuelta', 'cancelada'])->default('abierta');
            $table->text('descripcion');
            $table->foreignId('created_by')->nullable()->constrained('users')->setNullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->setNullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('preinscrito_id');
            $table->index('tipo_novedad_id');
            $table->index('estado');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novedades_preinscritos');
    }
};
