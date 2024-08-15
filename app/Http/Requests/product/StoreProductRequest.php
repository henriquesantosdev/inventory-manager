<?php

namespace App\Http\Requests\product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'productName' => 'required|max:120',
            'description' => 'nullable',
            'cost' => 'required',
            'saleValue' => 'required',
            'inStock' => 'required|numeric',
            'markup' => 'nullable|numeric',
        ];
    }

    public function attributes(): array
    {
        return [
            'productName' => 'Nome do Produto',
            'description' => 'Descrição',
            'cost' => 'Custo',
            'saleValue' => 'Valor de Venda',
            'inStock' => 'Em Estoque',
            'markup' => 'Markup',
        ];
    }
}
