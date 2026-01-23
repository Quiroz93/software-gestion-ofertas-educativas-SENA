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
        Schema::table('programas', function (Blueprint $table) {
            $table->string('modalidad')->nullable()->after('nivel_formacion_id');
            $table->string('jornada')->nullable()->after('modalidad');
            $table->string('titulo_otorgado')->nullable()->after('jornada');
            $table->string('codigo_snies')->nullable()->after('titulo_otorgado');
            $table->string('registro_calidad')->nullable()->after('codigo_snies');
            $table->date('fecha_registro')->nullable()->after('registro_calidad');
            $table->date('fecha_actualizacion')->nullable()->after('fecha_registro');
            $table->string('estado')->nullable()->after('fecha_actualizacion');
            $table->text('observaciones')->nullable()->after('estado');
            $table->unsignedBigInteger('centro_id')->nullable()->after('observaciones');
            $table->integer('cupos')->nullable()->after('centro_id');

            $table->foreign('centro_id')->references('id')->on('centros')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programas', function (Blueprint $table) {
            $table->dropForeign(['centro_id']);
            $table->dropColumn([
                'modalidad', 'jornada', 'titulo_otorgado', 'codigo_snies', 'registro_calidad',
                'fecha_registro', 'fecha_actualizacion', 'estado', 'observaciones', 'centro_id', 'cupos'
            ]);
        });
    }
};
