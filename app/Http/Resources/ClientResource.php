<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'id' => $this->id, 
        'name' => $this->name,
        'telephone' => $this->telephone,
        'cpf' => $this->cpf,
        'email' => $this->email,
        'address' => $this->address,
        'cep' => $this->cep,
        'birthDate' => $this->birthDate,
        ];  
     }
}
