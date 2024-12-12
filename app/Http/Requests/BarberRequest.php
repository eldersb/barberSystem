<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarberRequest extends FormRequest
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
            'name' => 'required|string|min:3|unique:barbers,name',
            'telephone' => 'required|numeric|digits:11',
            'status' => 'required|string|in:Disponível,Indisponível',       
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome do barbeiro é obrigatório.',
            'name.unique' => 'O nome desse barbeiro já existe.',
            'name.min' => 'O nome deve ter no mínimo 3 caracteres!',

            'telephone.required' => 'O telefone é obrigatório.',
            'telephone.numeric' => 'O telefone deve conter números',
            'telephone.digits' => 'O telefone deve conter até 11 digitos.',

            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser "Disponível" ou "Indisponível".'
        ];
    }
}
