<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preinscritos_rechazados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo')->nullable();
            $table->enum('tipo_documento', ['cc', 'ti', 'ce', 'ppt', 'pa', 'pep', 'nit'])->nullable();
            $table->string('numero_documento')->nullable()->index();
            $table->string('telefono')->nullable();
            $table->string('programa')->nullable();
            $table->string('correo')->nullable();
            $table->string('motivo');
            $table->unsignedInteger('fila_excel')->nullable();
            $table->json('datos_json')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preinscritos_rechazados');
    }
};
