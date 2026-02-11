<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('content_public_programas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('programa_id')->unique();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('motivational_title')->nullable();
            $table->text('motivational_text')->nullable();
            $table->string('motivational_image')->nullable();
            $table->string('competencias_fallback')->nullable();
            $table->timestamps();

            $table->foreign('programa_id')->references('id')->on('programas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_public_programas');
    }
};
