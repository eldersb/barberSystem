<?php

namespace App\Services;

use App\Models\Barber;

class BarberService
{

    protected $barber;

    public function __construct(Barber $barber)
    {
        $this->barber = $barber;
    }

    public function getAll()
    {
        return $this->barber->all();
    }

    public function searchByName(string $name)
    {
        return Barber::where('name', 'LIKE', "%{$name}%")->get();
    }

    public function create(array $data)
    {
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
