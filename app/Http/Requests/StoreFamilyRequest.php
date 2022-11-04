<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'  => 'required|string',
            'users' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Você precisa especificar o sobrenome identificador da família.',
            'name.string' => 'O sobrenome da família deve ser um texto.',
        ];
    }
}
