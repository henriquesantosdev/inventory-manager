<?php

namespace App\Http\Requests\client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'clientName' => 'required|string',
            'phoneNumber' => 'required|max:16|min:16|string'
        ];
    }

    public function attributes(): array
    {
        return [
            'clientName' => 'Nome do cliente',
            'phoneNumber' => 'Contato do cliente'
        ];
    }
}
