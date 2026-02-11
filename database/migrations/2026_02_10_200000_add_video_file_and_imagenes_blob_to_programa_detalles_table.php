<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programa_detalles', function (Blueprint $table) {
            $table->binary('video_file')->nullable()->after('video_url');
            $table->json('imagenes_blob')->nullable()->after('imagenes');
        });
    }

    public function down(): void
    {
        Schema::table('programa_detalles', function (Blueprint $table) {
            $table->dropColumn(['video_file', 'imagenes_blob']);
        });
    }
};
