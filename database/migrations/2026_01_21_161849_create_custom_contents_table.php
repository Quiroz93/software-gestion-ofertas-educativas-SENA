<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
     * Migracion para la tabla de contenidos personalizados por modulos
     */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_contents', function (Blueprint $table) {
            $table->id();

            // Relación polimórfica
            $table->morphs('contentable');
            // contentable_type | contentable_id

            // Identificador del contenido
            $table->string('key');
            // ej: banner_title, hero_text, slogan, hero_bg_color

            // Valor del contenido
            $table->text('value')->nullable();

            // Tipo de contenido
            $table->string('type')->default('text');
            // text | html | image | color | json

            $table->timestamps();

            // Evita duplicados por módulo
            $table->unique(['contentable_type', 'contentable_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_contents');
    }
};
