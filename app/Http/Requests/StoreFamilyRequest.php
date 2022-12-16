<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name'  => ['required', 'string', Rule::unique('families', 'name')->ignore($this->route('family'))],
            'users' => 'nullable|array'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Você precisa especificar o sobrenome identificador da família.',
            'name.string' => 'O sobrenome da família deve ser um texto.',
            'name.unique' => 'Já existe uma família com este nome.',
            'users.array' => 'Houve um erro com a seleção de usuários. Tente novamente.',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'users' => json_decode($this->users),
        ]);
    }
}
