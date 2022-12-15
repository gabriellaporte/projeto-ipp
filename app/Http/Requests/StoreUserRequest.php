<?php

namespace App\Http\Requests;

use App\Rules\DateStringRule;
use App\Rules\HousePhoneRule;
use App\Rules\MobilePhoneRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4000',
            'name' => ['required', 'string', Rule::unique('users', 'name')->whereNull('deleted_at')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
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
            'email.required' => 'O campo de email é obrigatório.',
            'name.required' => 'O campo de nome é obrigatório.',
            'name.unique' => 'Já existe alguém cadastrado com este mesmo nome.',
            'gender.required' => 'O campo de gênero é obrigatório.',
            'roles.required' => 'O campo de cargos é obrigatório.',
            'birth_date.required' => 'O campo de data de nascimento é obrigatório.',
            'profile_picture.image' => 'A foto de perfil precisa ser uma imagem.',
            'profile_picture.mimes' => 'A foto de perfil deve estar no formato JPG, JPEG, PNG ou GIF.',
            'profile_picture.max' => 'A foto de perfil só pode ter até 4 MB de tamanho.',
            'email.email' => 'O email informado está no formato inválido.',
            'email.unique' => 'Já existe um mesmo email cadastrado.',
            'family_id.integer' => 'Família inválida. Tente novamente'
        ];
    }

    public function attributes()
    {
        return [
            'birth_date' => 'data de nascimento',
            'enrollment_date' => 'data de arrolamento',
            'mobile_phone' => 'celular',
            'house_phone' => 'telefone fixo',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'birth_date' => $this->birth_date ? Carbon::createFromFormat('d/m/Y', $this->birth_date)->format('Y-m-d') : null,
            'enrollment_date' => $this->enrollment_date ? Carbon::createFromFormat('d/m/Y', $this->enrollment_date)->format('Y-m-d') : null,
        ]);
    }
}
