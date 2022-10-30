<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
            'title' => 'required|string',
            'message' => 'required|string',
            'users' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Preencha o campo de "Título" para enviar a notificação.',
            'message.required' => 'Preencha o conteúdo a ser enviado na notificação.',
            'users.required' => 'Selecione os usuários que receberão a notificação.'
        ];
    }
}
