<?php

use App\Models\CustomContent;
use Illuminate\Support\Facades\Storage;

if (!function_exists('getCustomContent')) {
    /**
     * Obtener contenido personalizado genérico por clave
     * 
     * @param string $modelName - Nombre del modelo (ej: 'oferta')
     * @param string $key - Clave del contenido
     * @param mixed $default - Valor por defecto si no existe
     * @return mixed
     */
    function getCustomContent($modelName, $key, $default = null)
    {
        $modelClass = 'App\\Models\\' . ucfirst($modelName);
        
        if (!class_exists($modelClass)) {
            return $default;
        }
        
        $content = CustomContent::where([
            'contentable_type' => $modelClass,
            'contentable_id' => 0,
            'key' => $key,
        ])->first();
        
        if (!$content) {
            return $default;
        }

        // ✅ FIX: Si es multimedia, validar que el archivo existe
        if (in_array($content->type, ['image', 'video', 'gif'])) {
            $filePath = $content->value;
            
            // Si es una ruta relativa, verificar en storage
            if (str_starts_with($filePath, 'media/')) {
                if (!Storage::disk('public')->exists($filePath)) {
                    // Archivo no existe - retornar default
                    return $default;
                }
            }
        }
        
        return $content->value ?? $default;
    }
}

if (!function_exists('getMediaUrl')) {
    /**
     * ✅ NEW: Obtener URL completa de multimedia verificada
     * 
     * @param string $modelName - Nombre del modelo
     * @param string $key - Clave del contenido
     * @param mixed $default - URL por defecto si no existe
     * @return string|null
     */
    function getMediaUrl($modelName, $key, $default = null)
    {
        $modelClass = 'App\\Models\\' . ucfirst($modelName);
        
        if (!class_exists($modelClass)) {
            return $default;
        }
        
        $content = CustomContent::where([
            'contentable_type' => $modelClass,
            'contentable_id' => 0,
            'key' => $key,
        ])->first();
        
        if (!$content) {
            return $default;
        }

        $filePath = $content->value;

        // Validar que sea multimedia
        if (!in_array($content->type, ['image', 'video', 'gif'])) {
            return $default;
        }

        // Validar existencia
        if (str_starts_with($filePath, 'media/')) {
            if (!Storage::disk('public')->exists($filePath)) {
                return $default;
            }
            
            // Retornar URL completa
            return asset('storage/' . $filePath);
        }

        return $default;
    }
}

if (!function_exists('getMediaMetadata')) {
    /**
     * ✅ NEW: Obtener metadatos de multimedia
     * 
     * @param string $modelName
     * @param string $key
     * @param string|null $metadataKey - Clave específica dentro de metadata
     * @param mixed $default
     * @return mixed
     */
    function getMediaMetadata($modelName, $key, $metadataKey = null, $default = null)
    {
        $modelClass = 'App\\Models\\' . ucfirst($modelName);
        
        if (!class_exists($modelClass)) {
            return $default;
        }
        
        $content = CustomContent::where([
            'contentable_type' => $modelClass,
            'contentable_id' => 0,
            'key' => $key,
        ])->first();
        
        if (!$content) {
            return $default;
        }

        // Si hay metadata JSON almacenada
        if ($content->metadata) {
            if ($metadataKey) {
                return $content->metadata[$metadataKey] ?? $default;
            }
            return $content->metadata;
        }

        return $default;
    }
}
