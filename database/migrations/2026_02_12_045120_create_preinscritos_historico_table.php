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
        Schema::create('preinscritos_historico', function (Blueprint $table) {
            $table->id();
            // Datos personales
            $table->string('nombres');
            $table->string('apellidos');
            // Documento
            $table->enum('tipo_documento', ['cc', 'ti', 'ce', 'ppt', 'pa', 'pep', 'nit']);
            $table->string('numero_documento')->index();
            // Contacto
            $table->string('celular_principal');
            $table->string('celular_alternativo')->nullable();
            $table->string('correo_principal');
            $table->string('correo_alternativo')->nullable();
            // Relación con Programa
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
            // Oferta asociada
            $table->unsignedBigInteger('oferta_id');
            $table->foreign('oferta_id')->references('id')->on('ofertas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preinscritos_historico');
    }
};
