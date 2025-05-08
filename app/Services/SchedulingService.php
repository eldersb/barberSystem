<?php

namespace App\Services;

use App\Models\Scheduling;
use App\Http\Resources\SchedulingResource;
use App\Models\Barber;

class SchedulingService
{
    protected $scheduling;

    public function __construct(Scheduling $scheduling)
    {
        $this->scheduling = $scheduling;
    }

    public function getAll()
    {
        $schedulings = $this->scheduling->with('categories')->get();
        return SchedulingResource::collection($schedulings);    
    }

    public function getById(string $id): SchedulingResource
    {
        $scheduling = Scheduling::findOrFail($id);
        $scheduling->load('categories');

        return new SchedulingResource($scheduling);
    }

    public function getByBarberName(string $barberName)
    {
        $barber = Barber::where('name', 'like', '%' . $barberName . '%')->first();

        if (!$barber) {
            return null; 
        }

        $schedullings = Scheduling::where('barber_id', $barber->id)
            ->with('categories')
            ->get();

        return SchedulingResource::collection($schedullings);
    }

    public function searchForDay(string $date)
    {
        return SchedulingResource::collection(Scheduling::forDay($date)->get());
    }

    public function create(array $data, array $categories): SchedulingResource
    {
        $scheduling = Scheduling::createService($data);

        $scheduling->CalculateTotalService($categories);

        $scheduling->load('categories');

        return new SchedulingResource($scheduling);
    }

    public function update(string $id, array $data): SchedulingResource
    {
        $schedulling = Scheduling::findOrFail($id);

        $schedulling = $schedulling->updateSchedullingWithCategories(
            $data,
            $data['categories']
        );

        $schedulling->load('categories');

        return new SchedulingResource($schedulling);
    }

    public function conclude(string $id): void
    {
        $scheduling = Scheduling::findOrFail($id);

        if ($scheduling->status === 'Finalizado') {
            throw new \Exception('Esse agendamento já foi finalizado.');
        }

        $scheduling->update(['status' => 'Finalizado']);
    }

}



?>