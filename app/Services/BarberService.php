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

    public function getActive()
    {
        $activeBarbers = $this->barber->where('status', 1)->get();
        return BarberResource::collection($activeBarbers);
    }

    public function getInactive()
    {
        $inactiveBarbers = $this->barber->where('status', 0)->get();
        return BarberResource::collection($inactiveBarbers);
    }

    public function searchByNameOrCpf(string $keyword)
    {
        $results = Barber::where(function($query) use ($keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('cpf', 'LIKE', "%{$keyword}%");
        })->get();
    
        
        return BarberResource::collection($results);
    }

    public function create(array $data)
    {

        $data['status'] = $data['status'] ?? 1; 
        // Solução provisória para erro de retorno do JSON,
        // Está retornando "Inativo", pois o laravel está avaliando o BarberRequest
        // Como ao chegar a requisição, vem sem o campo status, ele retorna null (equivalente ao 0)
        // Dessa forma, retorna "Inativo", mas cadastra no banco como "Ativo"
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
        $barber->status = 0; 
        $barber->save();
    }
}
