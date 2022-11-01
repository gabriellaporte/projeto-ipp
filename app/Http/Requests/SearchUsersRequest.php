<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchUsersRequest extends FormRequest
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
            'search_name' => 'nullable|string',
            'search_since' => 'nullable|date',
            'search_to' => 'nullable|date',
            'search_gender' => 'nullable|in:M,F'
        ];
    }

    public function messages()
    {
        return [
            'search_name.string' => 'O campo de nome deve ser um texto.',
            'search_since.date' => 'Os campos de data de nascimento são inválidos.',
            'search_to.date' => 'Os campos de data de nascimento são inválidos.',
            'search_gender.in' => 'O gênero especificado não existe.'
        ];
    }
}
