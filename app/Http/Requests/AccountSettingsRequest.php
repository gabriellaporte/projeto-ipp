<?php

namespace App\Http\Requests;

use App\Rules\DateStringRule;
use App\Rules\HousePhoneRule;
use App\Rules\MobilePhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountSettingsRequest extends FormRequest
{
    public function authorize()
    {
        if(!request()->user || request()->user->id != auth()->user()->id) {
            return false;
        }

        return true;
    }

    public function rules()
    {
        return [
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4000',
            'name' => ['required', 'string', Rule::unique('users', 'name')->ignore($this->route('id') ?? auth()->user()->id)->whereNull('deleted_at')],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->route('id') ?? auth()->user()->id)],
            'mobile_phone' => ['nullable', 'string', new MobilePhoneRule()],
            'house_phone' => ['nullable', 'string', new HousePhoneRule()],
            'birth_date' => ['required', 'string', new DateStringRule()],
            'enrollment_origin' => 'nullable|string',
            'enrollment_date' => ['nullable', 'string', new DateStringRule()],
            'gender' => 'nullable|string',
            'roles' => 'nullable|array',
            'family_id' => 'nullable|integer',
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
            'family_id.integer' => 'Família inválida. Tente novamente'
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
