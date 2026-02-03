<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Agrega campos para registrar y dar seguimiento a las novedades en preinscritos
     */
    public function up(): void
    {
        Schema::table('preinscritos', function (Blueprint $table) {
            // Descripción de la novedad
            $table->text('novedades')->nullable()->after('comentarios');
            
            // Tipo/categoría de la novedad
            $table->enum('tipo_novedad', [
                'cambio_programa',
                'cambio_contacto',
                'error_datos',
                'no_comparecencia',
                'cambio_ubicacion',
                'otra'
            ])->nullable()->after('novedades');
            
            // Estado de resolución
            $table->boolean('novedad_resuelta')->default(false)->after('tipo_novedad');
            
            // Fecha de resolución
            $table->timestamp('fecha_resolucion')->nullable()->after('novedad_resuelta');
            
            // Usuario que resolvió
            $table->unsignedBigInteger('resuelto_por')->nullable()->after('fecha_resolucion');
            
            // Índices para búsquedas frecuentes
            $table->index('tipo_novedad');
            $table->index('novedad_resuelta');
            
            // Relación con tabla users
            $table->foreign('resuelto_por')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('preinscritos', function (Blueprint $table) {
            // Eliminar relación extranjera primero
            $table->dropForeign(['resuelto_por']);
            
            // Eliminar índices
            $table->dropIndex(['tipo_novedad']);
            $table->dropIndex(['novedad_resuelta']);
            
            // Eliminar columnas
            $table->dropColumn([
                'novedades',
                'tipo_novedad',
                'novedad_resuelta',
                'fecha_resolucion',
                'resuelto_por'
            ]);
        });
    }
};
