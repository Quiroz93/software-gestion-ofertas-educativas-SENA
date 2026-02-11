<?php

namespace App\Http\Requests;

use App\Models\Preinscrito;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request para actualizar un preinscrito existente
 */
class UpdatePresritoRequest extends FormRequest
{
    /**
     * Determinar si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return $this->user()->can('preinscritos.edit');
    }

    /**
     * Obtener las reglas de validación que se aplican a la solicitud.
     */
    public function rules(): array
    {
        $presritoId = $this->route('presrito')->id ?? null;

        return [
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'tipo_documento' => ['required', Rule::in(array_keys(Preinscrito::getTiposDocumento()))],
            'numero_documento' => [
                'required',
                'string',
                'max:50',
                // Nota: La validación de duplicado se realiza en el controlador
                // basada en si los datos sensibles fueron modificados
            ],
            'celular_principal' => ['required', 'string', 'max:20'],
            'celular_alternativo' => ['nullable', 'string', 'max:20'],
            'correo_principal' => ['required', 'email', 'max:255'],
            'correo_alternativo' => ['nullable', 'email', 'max:255'],
            'programa_id' => ['required', 'exists:programas,id'],
            'estado' => ['required', Rule::in(array_keys(Preinscrito::getEstados()))],
            'comentarios' => ['nullable', 'string', 'max:1000'],
            
            // Campos de novedad (opcionales, pero si se marca tiene_novedad, algunos son requeridos)
            'tiene_novedad' => ['nullable', 'boolean'],
            'tipo_novedad_id' => ['nullable', 'exists:tipos_novedad,id'],
            'novedad_estado' => [
                Rule::requiredIf(function() {
                    return $this->has('tiene_novedad') && $this->tiene_novedad;
                }),
                'nullable',
                Rule::in(['abierta', 'en_gestion', 'resuelta', 'cancelada'])
            ],
            'novedad_descripcion' => [
                Rule::requiredIf(function() {
                    return $this->has('tiene_novedad') && $this->tiene_novedad;
                }),
                'nullable',
                'string',
                'max:2000'
            ],
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
            'celular_principal.required' => 'El celular principal es obligatorio.',
            'correo_principal.required' => 'El correo principal es obligatorio.',
            'correo_principal.email' => 'El correo principal debe ser un email válido.',
            'programa_id.required' => 'El programa es obligatorio.',
            'programa_id.exists' => 'El programa seleccionado no existe.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
            
            // Mensajes para campos de novedad
            'tipo_novedad_id.exists' => 'El tipo de novedad seleccionado no existe.',
            'novedad_estado.required' => 'El estado de la novedad es obligatorio cuando se marca que el preinscrito tiene novedad.',
            'novedad_estado.in' => 'El estado de la novedad seleccionado no es válido.',
            'novedad_descripcion.required' => 'La descripción de la novedad es obligatoria cuando se marca que el preinscrito tiene novedad.',
            'novedad_descripcion.max' => 'La descripción de la novedad no puede exceder los 2000 caracteres.',
        ];
    }

    /**
     * Preparar los datos para validación
     */
    protected function prepareForValidation(): void
    {
        $userId = $this->user()?->id;
        $id = $userId ?? null;
        $this->merge([
            'updated_by' => $id,
        ]);
    }
}
