<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('preinscritos_rechazados', function (Blueprint $table) {
            $table->unsignedBigInteger('programa_id')->nullable()->after('programa');
            $table->foreign('programa_id')
                ->references('id')->on('programas')
                ->onDelete('set null');
            $table->string('nombres')->nullable()->after('nombre_completo');
            $table->string('apellidos')->nullable()->after('nombres');
        });
    }

    public function down()
    {
        Schema::table('preinscritos_rechazados', function (Blueprint $table) {
            $table->dropForeign(['programa_id']);
            $table->dropColumn(['programa_id', 'nombres', 'apellidos']);
        });
    }
};
