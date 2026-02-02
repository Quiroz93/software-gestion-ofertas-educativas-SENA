<?php

namespace App\Http\Requests;

use App\Models\Preinscrito;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request para almacenar un nuevo preinscrito
 */
class StorePresritoRequest extends FormRequest
{
    /**
     * Determinar si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return $this->user()->can('preinscritos.create');
    }

    /**
     * Obtener las reglas de validación que se aplican a la solicitud.
     */
    public function rules(): array
    {
        return [
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'tipo_documento' => ['required', Rule::in(array_keys(Preinscrito::getTiposDocumento()))],
            'numero_documento' => ['required', 'string', 'max:50', Rule::unique('preinscritos', 'numero_documento')],
            'celular_principal' => ['required', 'string', 'max:20'],
            'celular_alternativo' => ['nullable', 'string', 'max:20'],
            'correo_principal' => ['required', 'email', 'max:255'],
            'correo_alternativo' => ['nullable', 'email', 'max:255'],
            'programa_id' => ['required', 'exists:programas,id'],
            'estado' => ['required', Rule::in(array_keys(Preinscrito::getEstados()))],
            'comentarios' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Obtener los mensajes de validación personalizados
     */
    public function messages(): array
    {
        return [
            'nombres.required' => 'El campo nombres es obligatorio.',
            'apellidos.required' => 'El campo apellidos es obligatorio.',
            'tipo_documento.required' => 'El tipo de documento es obligatorio.',
            'tipo_documento.in' => 'El tipo de documento seleccionado no es válido.',
            'numero_documento.required' => 'El número de documento es obligatorio.',
            'numero_documento.unique' => 'Este número de documento ya está registrado.',
            'celular_principal.required' => 'El celular principal es obligatorio.',
            'correo_principal.required' => 'El correo principal es obligatorio.',
            'correo_principal.email' => 'El correo principal debe ser un email válido.',
            'programa_id.required' => 'El programa es obligatorio.',
            'programa_id.exists' => 'El programa seleccionado no existe.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
        ];
    }

    /**
     * Preparar los datos para validación
     */
    protected function prepareForValidation(): void
    {
        $userId = $this->user()?->id;
        
        $this->merge([
            'created_by' => $userId,
            'updated_by' => $userId,
        ]);
    }
}
