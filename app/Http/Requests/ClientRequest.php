<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\Gender;

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
            'first_name' => 'required|string|min:3|unique:clients,first_name',
            'last_name' => 'required|string|min:3|unique:clients,last_name',
            'gender' => 'string|in:Masculino, Feminino, Outros',
            'birthDate' => 'required|date|before_or_equal:today',
            'document' => 'required|string|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/|unique:clients,document',
            'telephone' => 'required|string|max:11|unique:clients,telephone',
            'email' => 'string|email',         
            'street_name' => 'required|string',
            'street_number' => 'string',
            'city' => 'string',
            'neighborhood' => 'string',
            'state' => 'string',
            'cep' => 'required|string'
        ];
    }

    public function messages()
    {
            return [
                'first_name.required' => 'O nome é obrigatório.',
                'first_name.string' => 'O nome deve ser válido.',
                'first_name.unique' => 'O nome desse cliente já existe.',
                'first_name.min' => 'O nome deve conter no mínimo 3 caracteres',

                'last_name.required' => 'O sobrenome é obrigatório.',
                'last_name.string' => 'O sobrenome deve ser válido.',
                'last_name.unique' => 'O sobrenome desse cliente já existe.',
                'last_name.min' => 'O sobrenome deve conter no mínimo 3 caracteres',

                'gender.in' => 'O campo gênero deve ser Masculino, Feminino ou Outros.',
                'gender.string' => 'O campo gênero deve ser uma string',

                'birthDate.required' => 'A data de nascimento é obrigatória.',
                'birthDate.date' => 'A data de nascimento deve ser uma data válida.',
                'birthDate.before_or_equal' => 'A data de nascimento não pode ser no futuro.',

                'document.required' => 'Digite um cpf válido!',
                'document.regex' => 'O cpf deve ser em um formato válido!',
                'document.unique' => 'Já existe um cliente cadastrado com esse cpf.',

                'telephone.required' => 'O telefone é obrigatório.',
                'telephone.max' => 'O telefone deve conter no máximo 11 digitos.',
                'telephone.unique' => 'Este número de telefone já existe.',

                'email.email' => 'Digite um e-mail válido!',
                
                'street_name.required' => 'O endereço é obrigatório.',
                'street_name.string' => 'O endereço deve ser uma string.',

                'city' => 'A cidade deve ser uma string',

                'state' => 'O estado deve ser uma string',

                'cep.required' => 'O cep é obrigatório.',
                
            ];
            
    }
}
