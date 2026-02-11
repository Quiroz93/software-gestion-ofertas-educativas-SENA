<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programa_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('programa_id');
            $table->text('contextualizacion')->nullable();
            $table->string('video_url')->nullable();
            $table->json('imagenes')->nullable();
            $table->timestamps();

            $table->foreign('programa_id')->references('id')->on('programas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programa_detalles');
    }
};
