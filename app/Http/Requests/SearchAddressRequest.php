<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchAddressRequest extends FormRequest
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
            'search_city' => 'nullable|string',
            'search_area' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'search_city.string' => 'O campo de cidade é inválido.',
            'search_area.string' => 'O campo de bairro é inválido.',
        ];
    }
}
