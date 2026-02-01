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
        Schema::table('custom_contents', function (Blueprint $table) {
            $table->json('metadata')->nullable()->after('type')
                ->comment('Metadatos del archivo multimedia (dimensiones, tamaño, mime_type, etc.)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_contents', function (Blueprint $table) {
            if (Schema::hasColumn('custom_contents', 'metadata')) {
                $table->dropColumn('metadata');
            }
        });
    }
};
