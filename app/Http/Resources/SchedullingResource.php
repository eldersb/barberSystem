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
            'id' => $this->id,
            'barber_id' => $this->barber_id, 
            'client_id' => $this->client_id, 
            'categories' => CategoryResource::collection($this->whenLoaded('categories')), 
            'serviceTime' => $this->serviceTime,
            'serviceValue' => $this->serviceValue,
            'payment' => $this->payment,
            'status' => $this->status 
        ];

    }
}
