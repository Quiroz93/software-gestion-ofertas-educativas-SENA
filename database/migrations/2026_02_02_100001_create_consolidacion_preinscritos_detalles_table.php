<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consolidacion_preinscritos_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consolidacion_id')
                ->constrained('consolidaciones_preinscritos')
                ->onDelete('cascade');
            $table->string('tipo_documento', 20);
            $table->string('numero_documento', 50);
            $table->string('nombre_completo');
            $table->string('estado', 50)->nullable();
            $table->string('codigo_ficha', 50)->nullable();
            $table->string('nombre_programa')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->unique([
                'consolidacion_id',
                'tipo_documento',
                'numero_documento',
                'codigo_ficha'
            ], 'consol_preinsc_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consolidacion_preinscritos_detalles');
    }
};
