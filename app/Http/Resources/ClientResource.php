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
        'first_name' => $this->first_name,
        'last_name' => $this->last_name,
        'gender' => $this->gender,
        'birthDate' => $this->birthDate,
        'document' => $this->document,
        'telephone' => $this->telephone,
        'email' => $this->email,
        'street_name' => $this->street_name,
        'street_number' => $this->street_number,
        'neighborhood' => $this->neighborhood,
        'city' => $this->city,
        'state' => $this->state,
        'cep' => $this->cep,
        ];  
     }
}
