<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instructores', function (Blueprint $table) {
            if (!Schema::hasColumn('instructores', 'especialidad')) {
                $table->string('especialidad')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('instructores', function (Blueprint $table) {
            if (Schema::hasColumn('instructores', 'especialidad')) {
                $table->dropColumn('especialidad');
            }
        });
    }
};
