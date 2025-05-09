<?php

namespace App\Services;

use App\Models\Barber;
use App\Http\Resources\BarberResource;
use Illuminate\Support\Facades\Cache;

class BarberService
{

    protected $barber;

    public function __construct(Barber $barber)
    {
        $this->barber = $barber;
    }

    public function getAll()
    {

        return Cache::remember('barbers', 3600, function () {  
            return BarberResource::collection(Barber::all());
        });
    
    }

    public function getActive()
    {
         return Cache::remember('active_barbers', 3600, function () {
            $activeBarbers = $this->barber->where('status', 1)->get();
            return BarberResource::collection($activeBarbers);
         });
    }

    public function getInactive()
    {
        return Cache::remember('inactive_barbers', 3600, function () {
            $inactiveBarbers = $this->barber->where('status', 0)->get();
            return BarberResource::collection($inactiveBarbers);
        });
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

        $barber = $this->barber->create($data);

        Cache::forget('barbers');
        Cache::forget('active_barbers');

        Cache::put('active_barbers', BarberResource::collection($this->barber->where('status', 1)->get()), 3600);
        Cache::put('barbers', BarberResource::collection($this->barber->all()), 3600);

        return $barber;

    }

    public function getById(string $id)
    {
        return $this->barber->findOrFail($id);
    }

    public function update(string $id, array $data)
    {
        $barber = $this->getById($id);
       
        $barber->update($data);

        Cache::forget('barbers');

        Cache::put('barbers', BarberResource::collection($this->barber->all()), 3600);


        return $barber;
    }

    public function delete(string $id): void
    {
        $barber = Barber::findOrFail($id);
        $barber->status = 0; 
        $barber->save();
    }
}
