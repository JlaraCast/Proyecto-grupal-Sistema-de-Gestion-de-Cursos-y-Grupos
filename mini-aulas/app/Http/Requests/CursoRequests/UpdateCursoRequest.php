<?php

namespace App\Http\Requests\CursoRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCursoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'nombre' => 'required|string|max:255',
        'codigo' => 'required|string|max:50|unique:cursos,codigo',
        'descripcion' => 'nullable|string|max:1000',
    ];
}

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre debe tener un máximo de 255 caracteres.',

            'codigo.required' => 'El código es obligatorio.',
            'codigo.string' => 'El código debe ser una cadena de texto.',
            'codigo.max' => 'El código debe tener un máximo de 50 caracteres.',
            'codigo.unique' => 'El código ya se encuentra registrado.',

            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'descripcion.max' => 'La descripción debe tener un máximo de 1000 caracteres.',
        ];
    }
}
