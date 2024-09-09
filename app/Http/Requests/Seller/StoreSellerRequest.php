<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class StoreSellerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|min:3|alpha',
            'email' => 'required|email|unique:sellers,email',
            'password' => 'required|string|confirmed|min:6',
            'code' => 'required|integer|unique:sellers,code',
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
