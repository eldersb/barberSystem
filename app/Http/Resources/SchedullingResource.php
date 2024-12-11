<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchedullingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'barber_id' => $this->id, 
            'client_id' => $this->client_id, 
            'category_id' => $this->category_id,
            'serviceTime' => $this->serviceTime,
            'serviceValue' => $this->serviceValue,
            'payment' => $this->payment,
            'status' => $this->status 
        ];

    }
}
