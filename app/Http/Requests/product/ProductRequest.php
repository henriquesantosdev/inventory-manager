<?php

namespace App\Http\Requests\product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'productName' => 'required|max:120',
            'description' => 'nullable',
            'cost' => 'required|numeric',
            'saleValue' => 'required|numeric',
            'inStock' => 'required|numeric',
            'markup' => 'nullable|numeric'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'productName' => 'Nome do Produto',
            'description' => 'Descrição',
            'cost' => 'Custo',
            'saleValue' => 'Valor de Venda',
            'inStock' => 'Em Estoque',
            'markup' => 'Markup'
        ];
    }
}
