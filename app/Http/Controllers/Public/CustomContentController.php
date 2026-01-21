<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CustomContent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomContentController extends Controller
{
    /**
     * Almacena o actualiza contenido personalizado
     */
    public function store(Request $request)
    {
        // 🔐 Seguridad
        $this->authorize('public_content.edit');

        // 🧪 Validación
        $data = $request->validate([
            'model'     => 'required|string',
            'model_id'  => 'required|integer',
            'key'       => 'required|string|max:255',
            'value'     => 'nullable',
            'type'      => 'nullable|string|in:text,html,image,color,json',
        ]);

        // 🧠 Resolver modelo dinámicamente
        $modelClass = 'App\\Models\\' . Str::studly($data['model']);

        if (! class_exists($modelClass)) {
            return response()->json([
                'message' => 'Modelo no válido'
            ], 422);
        }

        $modelInstance = $modelClass::findOrFail($data['model_id']);

        // 💾 Crear o actualizar contenido
        $content = CustomContent::updateOrCreate(
            [
                'contentable_type' => $modelClass,
                'contentable_id'   => $modelInstance->id,
                'key'              => $data['key'],
            ],
            [
                'value' => $data['value'],
                'type'  => $data['type'] ?? 'text',
            ]
        );

        return response()->json([
            'message' => 'Contenido actualizado correctamente',
            'data'    => $content,
        ]);
    }
}
