<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('preinscritos', function (Blueprint $table) {
            $table->enum('estado', ['inscrito', 'por_inscribir', 'con_novedad', 'rechazado'])
                ->default('por_inscribir')
                ->change();
        });
    }

    public function down()
    {
        Schema::table('preinscritos', function (Blueprint $table) {
            $table->enum('estado', ['inscrito', 'por_inscribir', 'con_novedad'])
                ->default('por_inscribir')
                ->change();
        });
    }
};
