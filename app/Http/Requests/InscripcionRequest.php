<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class InscripcionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Solo usuarios autenticados pueden hacer solicitud de inscripción
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'observaciones' => ['nullable', 'string', 'max:500'],
            'acepta_terminos' => ['required', 'boolean'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'observaciones.string' => 'Las observaciones deben ser texto válido.',
            'observaciones.max' => 'Las observaciones no pueden exceder 500 caracteres.',
            'acepta_terminos.required' => 'Debes aceptar los términos y condiciones para inscribirte.',
            'acepta_terminos.boolean' => 'La aceptación de términos debe ser válida.',
        ];
    }
}
