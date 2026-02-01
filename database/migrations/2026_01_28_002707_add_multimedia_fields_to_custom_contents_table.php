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
        Schema::table('custom_contents', function (Blueprint $table) {
            // ✅ Agregar columna metadata como JSON para información adicional
            if (!Schema::hasColumn('custom_contents', 'metadata')) {
                $table->json('metadata')->nullable()->after('type')
                    ->comment('Metadata JSON para multimedia (width, height, size, mime_type, etc)');
            }

            // ✅ Agregar columna alt_text para accesibilidad
            if (!Schema::hasColumn('custom_contents', 'alt_text')) {
                $table->string('alt_text', 255)->nullable()->after('metadata')
                    ->comment('Texto alternativo para imágenes (accesibilidad)');
            }

            // ✅ Agregar columna title para tooltips
            if (!Schema::hasColumn('custom_contents', 'title')) {
                $table->string('title', 255)->nullable()->after('alt_text')
                    ->comment('Título/tooltip para elementos multimedia');
            }

            // ✅ Agregar índice compuesto para mejorar rendimiento de consultas
            if (!Schema::hasIndex('custom_contents', ['contentable_type', 'contentable_id', 'key'])) {
                $table->index(['contentable_type', 'contentable_id', 'key'], 'idx_contentable_key');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_contents', function (Blueprint $table) {
            // Eliminar índice si existe
            if (Schema::hasIndex('custom_contents', 'idx_contentable_key')) {
                $table->dropIndex('idx_contentable_key');
            }
            
            // Eliminar columnas agregadas
            if (Schema::hasColumn('custom_contents', 'metadata')) {
                $table->dropColumn('metadata');
            }
            if (Schema::hasColumn('custom_contents', 'alt_text')) {
                $table->dropColumn('alt_text');
            }
            if (Schema::hasColumn('custom_contents', 'title')) {
                $table->dropColumn('title');
            }
        });
    }
};
