<?php

namespace App\Http\Requests;

use App\Rules\DateStringRule;
use App\Rules\HousePhoneRule;
use App\Rules\MobilePhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
          'profilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4000',
          'userName' => 'required|string',
          'emailAddress' => 'required|email',
          'mobilePhone' => ['nullable', 'string', new MobilePhoneRule()],
          'housePhone' => ['nullable', 'string', new HousePhoneRule()],
          'birthDate' => ['required', 'string', new DateStringRule()],
          'enrollmentOrigin' => 'nullable|string',
          'enrollmentDate' => ['nullable', 'string', new DateStringRule()],
          'gender' => 'nullable|string',
          'roles' => 'nullable|array'
        ];
    }

    public function messages()
    {
      return [
        'emailAddress.required' => 'O campo de email é obrigatório.',
        'userName.required' => 'O campo de nome é obrigatório.',
        'gender.required' => 'O campo de gênero é obrigatório.',
        'roles.required' => 'O campo de cargos é obrigatório.',
        'birthDate.required' => 'O campo de data de nascimento é obrigatório.',
        'profilePicture.image' => 'A sua foto de perfil precisa ser uma imagem.',
        'profilePicture.mimes' => 'A sua foto de perfil deve estar no formato JPG, JPEG, PNG ou GIF.',
        'profilePicture.max' => 'A sua foto de perfil só pode ter até 4 MB de tamanho.',
        'emailAddress.email' => 'O email informado está no formato inválido.',
      ];
    }

    public function attributes()
    {
      return [
        'birthDate' => 'data de nascimento',
        'enrollmentDate' => 'data de arrolamento',
        'mobilePhone' => 'celular',
        'housePhone' => 'telefone fixo',
      ];
    }
}
