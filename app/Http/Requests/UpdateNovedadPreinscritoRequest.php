<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNovedadPreinscritoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('preinscritos.novedades.admin');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'tipo_novedad_id' => 'nullable|exists:tipos_novedad,id',
            'estado' => 'required|in:abierta,en_gestion,resuelta,cancelada',
            'descripcion' => 'required|string|max:2000',
            'comentario_cambio' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'tipo_novedad_id.exists' => 'El tipo de novedad seleccionado no existe.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.max' => 'La descripción no puede exceder 2000 caracteres.',
            'comentario_cambio.max' => 'El comentario no puede exceder 1000 caracteres.',
        ];
    }
}
