<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'price' => 'required|numeric|min:0.01'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome não pode ser nulo.',
            'name.min' => 'O nome deve ter mais que 3 caracteres.',
            'price.required' => 'O campo preço não pode ser nulo',
            'price.numeric' => 'O preço deve ser um número.',
            'price.min' => 'O preço deve ser maior que zero.'
        ];
    }

    
}
