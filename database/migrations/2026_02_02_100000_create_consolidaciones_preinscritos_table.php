<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consolidaciones_preinscritos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_consolidacion');
            $table->text('descripcion')->nullable();
            $table->unsignedInteger('total_archivos')->default(0);
            $table->unsignedInteger('total_registros')->default(0);
            $table->unsignedInteger('total_descartados')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consolidaciones_preinscritos');
    }
};
