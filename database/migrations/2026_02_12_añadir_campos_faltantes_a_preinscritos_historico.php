<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('preinscritos_historico', function (Blueprint $table) {
            $table->string('novedades')->nullable();
            $table->string('tipo_novedad')->nullable();
            $table->boolean('novedad_resuelta')->default(false);
            $table->timestamp('fecha_resolucion')->nullable();
            $table->unsignedBigInteger('resuelto_por')->nullable();
            $table->foreign('resuelto_por')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('preinscritos_historico', function (Blueprint $table) {
            $table->dropForeign(['resuelto_por']);
            $table->dropColumn(['novedades', 'tipo_novedad', 'novedad_resuelta', 'fecha_resolucion', 'resuelto_por']);
        });
    }
};
