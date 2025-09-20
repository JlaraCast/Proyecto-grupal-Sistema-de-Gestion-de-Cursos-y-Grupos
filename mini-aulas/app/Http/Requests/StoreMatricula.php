<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMatricula extends FormRequest
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
            'grupo_id' => 'required|exists:grupos,id',
            'user_id' => 'sometimes|exists:users,id',
        ];
    }

    public function attributes()
    {
        return [
            'grupo_id' => 'ID de grupo',
            'user_id' => 'ID de usuario',
        ];
    }
    public function messages()
    {
        return [
            'grupo_id.required' => 'El campo :attribute es obligatorio.',
            'grupo_id.exists' => 'El :attribute proporcionado no existe.',
            'user_id.exists' => 'El :attribute proporcionado no existe.',
            'user_id.sometimes' => 'El campo :attribute es opcional.',
        ];
    }
}
