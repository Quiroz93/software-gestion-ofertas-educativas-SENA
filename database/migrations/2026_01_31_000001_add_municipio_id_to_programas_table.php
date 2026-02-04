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
        if (!Schema::hasColumn('programas', 'municipio_id')) {
            Schema::table('programas', function (Blueprint $table) {
                $table->unsignedBigInteger('municipio_id')->nullable()->after('centro_id');
                $table->foreign('municipio_id')->references('id')->on('municipios')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('programas', 'municipio_id')) {
            Schema::table('programas', function (Blueprint $table) {
                $table->dropForeign(['municipio_id']);
                $table->dropColumn('municipio_id');
            });
        }
    }
};
