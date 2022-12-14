<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\DateStringRule;
use App\Rules\HousePhoneRule;
use App\Rules\MobilePhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'profilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4000',
            'userName' => ['required', 'string', Rule::unique('users', 'name')->ignore($this->route('id') ?? auth()->user()->id)],
            'emailAddress' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->route('id') ?? auth()->user()->id)],
            'mobilePhone' => ['nullable', 'string', new MobilePhoneRule()],
            'housePhone' => ['nullable', 'string', new HousePhoneRule()],
            'birthDate' => ['required', 'string', new DateStringRule()],
            'enrollmentOrigin' => 'nullable|string',
            'enrollmentDate' => ['nullable', 'string', new DateStringRule()],
            'gender' => 'nullable|string',
            'roles' => 'nullable|array',
            'family' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'emailAddress.required' => 'O campo de email é obrigatório.',
            'userName.required' => 'O campo de nome é obrigatório.',
            'userName.unique' => 'Já existe alguém cadastrado com este mesmo nome.',
            'gender.required' => 'O campo de gênero é obrigatório.',
            'roles.required' => 'O campo de cargos é obrigatório.',
            'birthDate.required' => 'O campo de data de nascimento é obrigatório.',
            'profilePicture.image' => 'A foto de perfil precisa ser uma imagem.',
            'profilePicture.mimes' => 'A foto de perfil deve estar no formato JPG, JPEG, PNG ou GIF.',
            'profilePicture.max' => 'A foto de perfil só pode ter até 4 MB de tamanho.',
            'emailAddress.email' => 'O email informado está no formato inválido.',
            'emailAddress.unique' => 'Já existe um mesmo email cadastrado.',
            'family.integer' => 'Família inválida. Tente novamente'
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
