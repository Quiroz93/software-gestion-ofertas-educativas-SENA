<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Preinscrito;
use App\Models\Programa;
use Illuminate\Support\Facades\DB;

class BaseDatosDosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar preinscritos existentes (respetando foreign keys)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Preinscrito::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Leer archivo BaseDeDatosDos.md
        $file = base_path('archivos de sustentacion/BaseDeDatosDos.md');
        if (!file_exists($file)) {
            $this->command->error('Archivo BaseDeDatosDos.md no encontrado');
            return;
        }
        
        $contenido = file_get_contents($file);
        $lineas = explode("\n", $contenido);
        
        $contador = 0;
        $errores = [];
        $tiposDocumentoValidos = ['cc', 'ti', 'ppt', 'ce', 'pa', 'pep', 'nit'];
        
        // Obtener todos los programas para mapeo
        $programas = Programa::all()->keyBy('numero_ficha');
        
        foreach ($lineas as $idx => $linea) {
            // Saltar encabezado y líneas vacías
            if ($idx === 0 || trim($linea) === '') {
                continue;
            }
            
            // Parsear campos (tab-separated)
            $campos = explode("\t", $linea);
            
            if (count($campos) < 5) {
                $errores[] = "Línea $idx: Insuficientes campos (" . count($campos) . ")";
                continue;
            }
            
            $nombre = trim($campos[0] ?? '');
            $tipoDoc = strtolower(trim($campos[1] ?? ''));
            $numDoc = trim($campos[2] ?? '');
            $telefono = trim($campos[3] ?? '');
            $programa = trim($campos[4] ?? '');
            $ficha = trim($campos[5] ?? '');
            $correo = trim($campos[6] ?? '') ?: null;
            $novedad = trim($campos[7] ?? '') ?: null;

            if ($numDoc === 'null') {
                $numDoc = '';
            }
            if ($telefono === 'null') {
                $telefono = '';
            }
            if ($programa === 'null') {
                $programa = '';
            }
            if ($ficha === 'null') {
                $ficha = '';
            }
            if ($correo === 'null') {
                $correo = null;
            }
            if ($novedad === 'null') {
                $novedad = null;
            }
            
            // Validaciones básicas
            if (empty($nombre) || empty($numDoc)) {
                $errores[] = "Línea $idx: Nombre o documento vacío";
                continue;
            }

            if (Preinscrito::where('numero_documento', $numDoc)->exists()) {
                $errores[] = "Línea $idx ($nombre): documento duplicado";
                continue;
            }
            
            // Normalizar tipo de documento
            if (!in_array($tipoDoc, $tiposDocumentoValidos)) {
                $tipoDoc = 'cc';
            }
            
            // Separar nombres y apellidos
            $partes = explode(' ', $nombre, 2);
            $nombres = $partes[0] ?? $nombre;
            $apellidos = $partes[1] ?? '';
            
            // Obtener programa_id desde ficha
            $programaId = null;
            if (!empty($ficha) && isset($programas[$ficha])) {
                $programaId = $programas[$ficha]->id;
            }
            
            // Si no encontró programa por ficha, intentar por nombre
            if (empty($programaId) && !empty($programa)) {
                $prog = Programa::where('nombre', 'LIKE', '%' . $programa . '%')->first();
                if ($prog) {
                    $programaId = $prog->id;
                }
            }

            if (empty($programaId)) {
                $errores[] = "Línea $idx ($nombre): programa no encontrado";
                continue;
            }
            
            // Determinar estado: si hay novedad, 'con_novedad', si no 'inscrito'
            $estado = (!empty($novedad) && $novedad !== 'null') ? 'con_novedad' : 'inscrito';
            
            // Crear registro
            $correoNormalizado = (!empty($correo) && $correo !== 'null')
                ? $correo
                : "sin-correo-{$numDoc}@example.invalid";
            $telefonoNormalizado = (!empty($telefono) && $telefono !== 'null')
                ? $telefono
                : '0000000000';

            $data = [
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'tipo_documento' => $tipoDoc,
                'numero_documento' => $numDoc,
                'celular_principal' => $telefonoNormalizado,
                'correo_principal' => $correoNormalizado,
                'programa_id' => $programaId,
                'estado' => $estado,
                'comentarios' => (!empty($novedad) && $novedad !== 'null') ? $novedad : null,
            ];
            
            try {
                Preinscrito::create($data);
                $contador++;
            } catch (\Exception $e) {
                $errores[] = "Línea $idx ($nombre): " . $e->getMessage();
            }
        }
        
        $this->command->info("✅ $contador preinscritos sembrados correctamente desde BaseDeDatosDos.md");
        
        if (!empty($errores)) {
            $this->command->warn("\n⚠️ Se encontraron " . count($errores) . " errores durante la siembra:");
            foreach (array_slice($errores, 0, 10) as $error) {
                $this->command->warn("  - $error");
            }
            if (count($errores) > 10) {
                $this->command->warn("  ... y " . (count($errores) - 10) . " errores más");
            }
        }
    }
}
