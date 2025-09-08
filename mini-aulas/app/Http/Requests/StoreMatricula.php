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
            'user_id' => 'required|exists:users,id',
            'grupo_id' => 'required|exists:grupos,id',
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'ID de usuario',
            'grupo_id' => 'ID de grupo',
        ];
    }
    public function messages()
    {
        return [
            'user_id.required' => 'El campo :attribute es obligatorio.',
            'user_id.exists' => 'El :attribute proporcionado no existe.',
            'grupo_id.required' => 'El campo :attribute es obligatorio.',
            'grupo_id.exists' => 'El :attribute proporcionado no existe.',
        ];
    }
}
