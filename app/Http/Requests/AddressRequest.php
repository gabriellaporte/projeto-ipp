<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddressRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
      return [
        'nice_name' => 'required|array|min:1',
        'nice_name.*' => ['required', 'string', 'distinct'],
        'cep' => 'required|array|min:1',
        'cep.*' => 'required|string',
        'address' => 'required|array|min:1',
        'address.*' => 'required|string',
        'area' => 'required|array|min:1',
        'area.*' => 'required|string',
        'house_number' => 'required|array|min:1',
        'house_number.*' => 'required|string',
        'address_complement' => 'nullable|array|min:1',
        'address_complement.*' => 'nullable|string',
        'city' => 'required|array|min:1',
        'city.*' => 'required|string',
        'state' => 'required|array|min:1',
        'state.*' => 'required|string',
      ];
    }

    public function messages()
    {
      return [
        'nice_name.required' => 'Você deve especificar um apelido para o(s) endereço(s).',
        'nice_name.min' => 'Você deve especificar um apelido para o(s) endereço(s).',
        'nice_name.*.required' => 'Você deve especificar um apelido para o(s) endereço(s).',
        'nice_name.*.distinct' => 'O nome de cada endereço não pode se repetir.',
        'cep.required' => 'Você deve especificar um CEP para o(s) endereço(s).',
        'cep.min' => 'Você deve especificar um CEP para o(s) endereço(s).',
        'cep.*.required' => 'Você deve especificar um CEP para o(s) endereço(s).',
        'address.required' => 'Você deve especificar um endereço para o(s) endereço(s).',
        'address.min' => 'Você deve especificar um endereço para o(s) endereço(s).',
        'address.*.required' => 'Você deve especificar um endereço para o(s) endereço(s).',
        'area.required' => 'Você deve especificar um bairro para o(s) endereço(s).',
        'area.min' => 'Você deve especificar um bairro para o(s) endereço(s).',
        'area.*.required' => 'Você deve especificar um bairro para o(s) endereço(s).',
        'house_number.required' => 'Você deve especificar um número para o(s) endereço(s).',
        'house_number.min' => 'Você deve especificar um número para o(s) endereço(s).',
        'house_number.*.required' => 'Você deve especificar um número para o(s) endereço(s).',
        'city.required' => 'Você deve especificar uma cidade para o(s) endereço(s).',
        'city.min' => 'Você deve especificar uma cidade para o(s) endereço(s).',
        'city.*.required' => 'Você deve especificar uma cidade para o(s) endereço(s).',
        'state.required' => 'Você deve especificar um estado para o(s) endereço(s).',
        'state.min' => 'Você deve especificar um estado para o(s) endereço(s).',
        'state.*.required' => 'Você deve especificar um estado para o(s) endereço(s).',
      ];
    }
}
