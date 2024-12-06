<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'telephone' => 'required|string',
            'address' => 'required|string',
            'birthDate' => 'required|date|before_or_equal:today'
        ];
    }

    public function messages()
    {
            return [
                'name.required' => 'O nome é obrigatório.',
                'name.string' => 'O nome deve ser uma string.',

                'telephone.required' => 'O telefone é obrigatório.',
                'telephone.string' => 'O telefone deve ser uma string.',
                
                'address.required' => 'O endereço é obrigatório.',
                'address.string' => 'O endereço deve ser uma string.',
                
                'birthDate.required' => 'A data de nascimento é obrigatória.',
                'birthDate.date' => 'A data de nascimento deve ser uma data válida.',
                'birthDate.before_or_equal' => 'A data de nascimento não pode ser no futuro.'
            ];
            
    }
}
