<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportPreinscritosConsolidacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'archivos' => ['required', 'array', 'min:1'],
            'archivos.*' => ['file', 'mimes:xls,xlsx'],
        ];
    }

    public function messages(): array
    {
        return [
            'archivos.required' => 'Debe cargar al menos un archivo Excel.',
            'archivos.array' => 'El formato de archivos no es válido.',
            'archivos.min' => 'Debe cargar al menos un archivo Excel.',
            'archivos.*.mimes' => 'Solo se permiten archivos con extensión .xls o .xlsx.',
        ];
    }
}
