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
        Schema::create('novedades_historial', function (Blueprint $table) {
            $table->id();
            $table->foreignId('novedad_id')->constrained('novedades_preinscritos')->cascadeOnDelete();
            $table->enum('estado_anterior', ['abierta', 'en_gestion', 'resuelta', 'cancelada']);
            $table->enum('estado_nuevo', ['abierta', 'en_gestion', 'resuelta', 'cancelada']);
            $table->text('comentario')->nullable();
            $table->foreignId('changed_by')->nullable()->constrained('users')->setNullOnDelete();
            $table->timestamps();

            // Índices
            $table->index('novedad_id');
            $table->index('changed_by');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novedades_historial');
    }
};
