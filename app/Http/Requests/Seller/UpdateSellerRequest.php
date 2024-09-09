<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSellerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('sellers')->ignore($this->route('seller')),
            ],
            'code' => [
                'required',
                'integer',
                Rule::unique('sellers')->ignore($this->route('seller')),
            ],
            'password' => 'sometimes|string|confirmed|min:6',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'O :attribute é obrigatório.',
            'email.required' => 'O :attribute é obrigatório.',
            'email.unique' => 'O :attribute já está cadastrado',
            'code.unique' => 'O código já está cadastrado',
            'password.required' => 'A senha é obrigatória',
            'password.confirmed' => 'É necessário que a confirmação da senha seja identica a senha.',
        ];
    }

}
