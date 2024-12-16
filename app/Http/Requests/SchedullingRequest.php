<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchedullingRequest extends FormRequest
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
            'barber_id' => 'required|exists:barbers,id',  
            'client_id' => 'required|exists:clients,id',  
            'categories' => 'required|array', 
            'categories.*' =>  'required|exists:categories,id',
            'serviceTime' => 'required|date|after_or_equal:today', 
            'payment' => 'required|string|in:Dinheiro,Pix,Débito,Crédito', 
            'status' => 'required|in:Em andamento,Finalizado'
        ];
    }

    public function messages()
    {
        return [
            'barber_id.required' => 'O campo Barber ID é obrigatório.',
            'barber_id.exists' => 'O barbeiro especificado não existe.',
            'client_id.required' => 'O campo Client ID é obrigatório.',
            'client_id.exists' => 'O cliente especificado não existe.',
            'serviceTime.required' => 'O campo Service Time é obrigatório.',
            'serviceTime.date' => 'O campo Service Time deve ser uma data válida.',
            'serviceTime.after_or_equal' => 'O campo Service Time não pode ser uma data no passado.',
            'payment.required' => 'O campo Payment é obrigatório.',
            'payment.in' => 'O pagamento deve ser Dinheiro, Pix, Débito ou Crédito.',
            'status.required' => 'O campo Status é obrigatório.',
            'status.in' => 'O Status deve ser "Em andamento" ou "Finalizado".',
        ];
    }
}
