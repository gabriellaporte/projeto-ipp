<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string',
            'content' => 'required|string',
            'users' => 'required|array|min:1'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Preencha o campo de "Título" para enviar a notificação.',
            'content.required' => 'Preencha o conteúdo a ser enviado na notificação.',
            'users.required' => 'Selecione os usuários que receberão a notificação.',
            'users.array' => 'Houve um erro com a seleção de usuários. Tente novamente.',
            'users.min' => 'Selecione ao menos 1 usuário para receber a notificação.',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'users' => json_decode($this->users),
        ]);
    }
}
