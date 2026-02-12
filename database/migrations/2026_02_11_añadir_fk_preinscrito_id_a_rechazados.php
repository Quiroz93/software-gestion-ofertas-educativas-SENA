<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('preinscritos_rechazados', function (Blueprint $table) {
            $table->unsignedBigInteger('preinscrito_id')->nullable()->after('id');
            $table->foreign('preinscrito_id')
                ->references('id')->on('preinscritos')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('preinscritos_rechazados', function (Blueprint $table) {
            $table->dropForeign(['preinscrito_id']);
            $table->dropColumn('preinscrito_id');
        });
    }
};
