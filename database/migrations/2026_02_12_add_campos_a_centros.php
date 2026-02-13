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
        Schema::table('centros', function (Blueprint $table) {
            if (!Schema::hasColumn('centros', 'codigo')) {
                $table->string('codigo')->unique()->nullable();
            }
            if (!Schema::hasColumn('centros', 'telefono')) {
                $table->string('telefono')->nullable();
            }
            if (!Schema::hasColumn('centros', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('centros', 'estado')) {
                $table->string('estado')->default('activo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('centros', function (Blueprint $table) {
            $table->dropColumn(['codigo', 'direccion', 'telefono', 'email', 'estado']);
        });
    }
};
