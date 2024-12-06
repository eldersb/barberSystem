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
            'name' => 'required|string|max:255',
            'telephone' => 'required|string',
            'status' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome do barbeiro é obrigatório.',
            'telephone.required' => 'O telefone é obrigatório.',
            'status.required' => 'O status é obrigatório.',
        ];
    }
}
