<?php

use App\Models\CustomContent;

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
        
        return $content?->value ?? $default;
    }
}
