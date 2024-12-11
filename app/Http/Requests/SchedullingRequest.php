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
            'category_id' => 'required|exists:category,id',  
            'serviceTime' => 'required|date|after_or_equal:today', 
            'serviceValue' => 'required|numeric|min:0',
            'payment' => 'required|string', 
            'status' => 'required|in:Em andamento,Finalizado'
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'barber_id.required' => 'O campo Barber ID é obrigatório.',
    //         'barber_id.exists' => 'O barbeiro especificado não existe.',
    //         'client_id.required' => 'O campo Client ID é obrigatório.',
    //         'client_id.exists' => 'O cliente especificado não existe.',
    //         'category_id.required' => 'O campo Category ID é obrigatório.',
    //         'category_id.exists' => 'A categoria especificada não existe.',
    //         'serviceTime.required' => 'O campo Service Time é obrigatório.',
    //         'serviceTime.date' => 'O campo Service Time deve ser uma data válida.',
    //         'serviceTime.after_or_equal' => 'O campo Service Time não pode ser uma data no passado.',
    //         'serviceValue.required' => 'O campo Service Value é obrigatório.',
    //         'serviceValue.numeric' => 'O campo Service Value deve ser um valor numérico.',
    //         'serviceValue.min' => 'O valor do serviço não pode ser negativo.',
    //         'payment.required' => 'O campo Payment é obrigatório.',
    //         'payment.numeric' => 'O campo Payment deve ser um valor numérico.',
    //         'payment.min' => 'O valor do pagamento não pode ser negativo.',
    //         'payment.same' => 'O valor do pagamento deve ser igual ao valor do serviço.',
    //         'status.required' => 'O campo Status é obrigatório.',
    //         'status.in' => 'O campo Status deve ser um dos seguintes: Scheduled, Completed, Cancelled.',
    //     ];
    // }
}
