<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('municipios', function (Blueprint $table) {
            if (!Schema::hasColumn('municipios', 'estado')) {
                $table->string('estado')->default('activo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('municipios', function (Blueprint $table) {
            if (Schema::hasColumn('municipios', 'estado')) {
                $table->dropColumn('estado');
            }
        });
    }
};
