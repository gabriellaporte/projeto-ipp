<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type_name' => ['required', 'string', Rule::unique('tithes_offerings_types', 'type_name')],
            'is_in_cash' => ['required', 'boolean']
        ];
    }

    public function messages()
    {
        return [
            'type_name.required' => 'O campo do nome da categoria é obrigatório.',
            'type_name.string' => 'O nome da categoria deve ser um texto.',
            'type_name.unique' => 'O nome da categoria já existe.',
            'is_in_cash.required' => 'Selecione o tipo da categoria.',
            'is_in_cash.boolean' => 'Tipo da categoria inválido.',
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'is_in_cash' => request()->is_in_cash == "1",
        ]);
    }
}
