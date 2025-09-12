<?php

namespace App\Http\Requests\GrupoRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrupoRequest extends FormRequest
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
            'numero_grupo' => [
                'required',
                'integer',
                'min:1',
                'unique:grupos,numero_grupo,NULL,id,curso_id,' . $this->curso_id,
            ],
            'cupo_maximo' => 'required|integer|min:1|max:100',
            'curso_id' => 'required|integer|exists:cursos,id',
            'profesor_id' => 'required|integer|exists:users,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'numero_grupo.required' => 'El número de grupo es obligatorio.',
            'numero_grupo.integer' => 'El número de grupo debe ser un número entero.',
            'numero_grupo.min' => 'El número de grupo debe ser al menos 1.',
            'numero_grupo.unique' => 'Ya existe un grupo con este número para el curso seleccionado.',

            'cupo_maximo.required' => 'El cupo máximo es obligatorio.',
            'cupo_maximo.integer' => 'El cupo máximo debe ser un número entero.',
            'cupo_maximo.min' => 'El cupo máximo debe ser al menos 1.',
            'cupo_maximo.max' => 'El cupo máximo no puede exceder 100.',

            'curso_id.required' => 'El curso es obligatorio.',
            'curso_id.integer' => 'El curso debe ser un número entero.',
            'curso_id.exists' => 'El curso no existe en nuestros registros.',

            'profesor_id.required' => 'El profesor es obligatorio.',
            'profesor_id.integer' => 'El profesor debe ser un número entero.',
            'profesor_id.exists' => 'El profesor no existe en nuestros registros.',
        ];
    }
}
