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
        Schema::create('preinscritos', function (Blueprint $table) {
            $table->id();
            
            // Datos personales
            $table->string('nombres');
            $table->string('apellidos');
            
            // Documento
            $table->enum('tipo_documento', ['cc', 'ti', 'ce', 'ppt', 'pa', 'pep', 'nit']);
            $table->string('numero_documento')->unique()->index();
            
            // Contacto
            $table->string('celular_principal');
            $table->string('celular_alternativo')->nullable();
            $table->string('correo_principal');
            $table->string('correo_alternativo')->nullable();
            
            // Relación con Programa (por numero_ficha)
            $table->unsignedBigInteger('programa_id');
            $table->foreign('programa_id')->references('id')->on('programas')->onDelete('cascade');
            
            // Estado del preinscrito
            $table->enum('estado', ['inscrito', 'por_inscribir', 'con_novedad'])->default('por_inscribir');
            
            // Información adicional
            $table->text('comentarios')->nullable();
            
            // Auditoría
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices de búsqueda
            $table->index('programa_id');
            $table->index('estado');
            $table->index('tipo_documento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preinscritos');
    }
};
