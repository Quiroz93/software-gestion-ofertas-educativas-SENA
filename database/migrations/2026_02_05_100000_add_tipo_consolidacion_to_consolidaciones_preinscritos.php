<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consolidaciones_preinscritos', function (Blueprint $table) {
            // Tipo de consolidación: 'preinscritos', 'regional_completo', 'regional_esencial'
            $table->string('tipo_consolidacion')->default('preinscritos')->after('descripcion');
        });

        Schema::table('consolidacion_preinscritos_detalles', function (Blueprint $table) {
            // Campos adicionales para REGIONAL SANTANDER (todos opcionales)
            $table->string('nis', 50)->nullable()->after('nombre_programa');
            $table->string('correo_electronico', 100)->nullable()->after('nis');
            $table->string('telefono_fijo', 20)->nullable()->after('correo_electronico');
            $table->string('telefono_movil', 20)->nullable()->after('telefono_fijo');
            $table->string('tipo_prueba', 50)->nullable()->after('telefono_movil');
            $table->string('resultado_prueba', 30)->nullable()->after('tipo_prueba');
            $table->dateTime('fecha_cargue')->nullable()->after('resultado_prueba');
            $table->string('estado_prueba', 100)->nullable()->after('fecha_cargue');
            $table->text('motivo_prueba')->nullable()->after('estado_prueba');
            $table->dateTime('fecha_prueba')->nullable()->after('motivo_prueba');
            $table->string('acceso_preferente', 100)->nullable()->after('fecha_prueba');
            $table->string('digito', 2)->nullable()->after('acceso_preferente');
            $table->string('dia_pico_placa', 100)->nullable()->after('digito');
        });
    }

    public function down(): void
    {
        Schema::table('consolidacion_preinscritos_detalles', function (Blueprint $table) {
            $table->dropColumn([
                'nis',
                'correo_electronico',
                'telefono_fijo',
                'telefono_movil',
                'tipo_prueba',
                'resultado_prueba',
                'fecha_cargue',
                'estado_prueba',
                'motivo_prueba',
                'fecha_prueba',
                'acceso_preferente',
                'digito',
                'dia_pico_placa',
            ]);
        });

        Schema::table('consolidaciones_preinscritos', function (Blueprint $table) {
            $table->dropColumn('tipo_consolidacion');
        });
    }
};
