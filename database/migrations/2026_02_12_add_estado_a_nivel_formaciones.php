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
        Schema::table('nivel_formaciones', function (Blueprint $table) {
            if (!Schema::hasColumn('nivel_formaciones', 'estado')) {
                $table->string('estado')->default('activo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nivel_formaciones', function (Blueprint $table) {
            if (Schema::hasColumn('nivel_formaciones', 'estado')) {
                $table->dropColumn('estado');
            }
        });
    }
};
