<?php

namespace App\Services;

use App\Models\Barber;
use App\Http\Resources\BarberResource;

class BarberService
{

    protected $barber;

    public function __construct(Barber $barber)
    {
        $this->barber = $barber;
    }

    public function getAll()
    {
        return BarberResource::collection($this->barber->all());        
    }

    public function searchByNameOrCpf(string $keyword)
    {
        $results = Barber::where(function($query) use ($keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('cpf', 'LIKE', "%{$keyword}%");
        })->get();
    
        // Retorna os resultados formatados com BarberResource
        return BarberResource::collection($results);
    }

    public function create(array $data)
    {

        if (isset($data['status']) && is_string($data['status'])) {
            $data['status'] = $data['status'] === 'Ativo' ? 1 : 0;
        }

        return $this->barber->create($data);
    }

    public function getById(string $id)
    {
        return $this->barber->findOrFail($id);
    }

    public function update(string $id, array $data)
    {
        $barber = $this->getById($id);
       
        $barber->update($data);

        return $barber;
    }

    public function delete(string $id): void
    {
        $barber = Barber::findOrFail($id);
        $barber->delete();
    }
}
