<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LoginRequest extends FormRequest
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
        'email' => 'required|email',
        'password' => 'required|string'
      ];
    }

    public function messages()
    {
      return [
        'email.required' => 'Preencha o campo de email para se conectar.',
        'email.email' => 'O email informado está no formato inválido.',
        'password.required' => 'Preencha o campo da senha para se conectar.'
      ];
    }
}
