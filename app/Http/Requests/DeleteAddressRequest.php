<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteAddressRequest extends FormRequest
{
    public function authorize()
    {
        if(!request()->address || !auth()->user()->addresses->pluck('id')->contains(request()->address->id)) {
            return false;
        }

        return true;
    }

    public function rules()
    {
        return [];
    }
}
