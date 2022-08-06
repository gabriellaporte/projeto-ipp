<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddressRequest extends FormRequest
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
        'niceName' => 'required|array|min:1',
        'niceName.*' => ['required', 'string', 'distinct'],
        'cep' => 'required|array|min:1',
        'cep.*' => 'required|string',
        'address' => 'required|array|min:1',
        'address.*' => 'required|string',
        'area' => 'required|array|min:1',
        'area.*' => 'required|string',
        'houseNumber' => 'required|array|min:1',
        'houseNumber.*' => 'required|string',
        'addressComplement' => 'nullable|array|min:1',
        'addressComplement.*' => 'nullable|string',
        'city' => 'required|array|min:1',
        'city.*' => 'required|string',
        'state' => 'required|array|min:1',
        'state.*' => 'required|string',
      ];
    }

    public function messages()
    {
      return [
        'niceName.required' => 'Você deve especificar um apelido para o(s) endereço(s).',
        'niceName.min' => 'Você deve especificar um apelido para o(s) endereço(s).',
        'niceName.*.required' => 'Você deve especificar um apelido para o(s) endereço(s).',
        'niceName.*.distinct' => 'O nome de cada endereço não pode se repetir.',
        'cep.required' => 'Você deve especificar um CEP para o(s) endereço(s).',
        'cep.min' => 'Você deve especificar um CEP para o(s) endereço(s).',
        'cep.*.required' => 'Você deve especificar um CEP para o(s) endereço(s).',
        'address.required' => 'Você deve especificar um endereço para o(s) endereço(s).',
        'address.min' => 'Você deve especificar um endereço para o(s) endereço(s).',
        'address.*.required' => 'Você deve especificar um endereço para o(s) endereço(s).',
        'area.required' => 'Você deve especificar um bairro para o(s) endereço(s).',
        'area.min' => 'Você deve especificar um bairro para o(s) endereço(s).',
        'area.*.required' => 'Você deve especificar um bairro para o(s) endereço(s).',
        'houseNumber.required' => 'Você deve especificar um número para o(s) endereço(s).',
        'houseNumber.min' => 'Você deve especificar um número para o(s) endereço(s).',
        'houseNumber.*.required' => 'Você deve especificar um número para o(s) endereço(s).',
        'city.required' => 'Você deve especificar uma cidade para o(s) endereço(s).',
        'city.min' => 'Você deve especificar uma cidade para o(s) endereço(s).',
        'city.*.required' => 'Você deve especificar uma cidade para o(s) endereço(s).',
        'state.required' => 'Você deve especificar um estado para o(s) endereço(s).',
        'state.min' => 'Você deve especificar um estado para o(s) endereço(s).',
        'state.*.required' => 'Você deve especificar um estado para o(s) endereço(s).',
      ];
    }
}
