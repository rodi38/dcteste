<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'seller_id' => 'required|exists:sellers,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.amount' => 'required|integer|min:1',
            'installments' => 'required|array',
            'installments.*.value' => 'required|numeric|min:0',
            'installments.*.expiration_date' => 'required|date',
            'installments.*.paid' => 'nullable|in:0,1',
        ];
    }
}
