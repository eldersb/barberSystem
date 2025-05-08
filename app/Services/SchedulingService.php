<?php

namespace App\Services;

use App\Models\Schedulling;
use App\Http\Resources\SchedullingResource;
use App\Models\Barber;

class SchedulingService
{
    protected $scheduling;

    public function __construct(Schedulling $scheduling)
    {
        $this->scheduling = $scheduling;
    }

    public function getAll()
    {
        $schedullings = $this->scheduling->with('categories')->get();
        return SchedullingResource::collection($schedullings);    
    }

    public function getById(string $id): SchedullingResource
    {
        $schedulling = Schedulling::findOrFail($id);
        $schedulling->load('categories');

        return new SchedullingResource($schedulling);
    }

    public function getByBarberName(string $barberName)
    {
        $barber = Barber::where('name', 'like', '%' . $barberName . '%')->first();

        if (!$barber) {
            return null; 
        }

        $schedullings = Schedulling::where('barber_id', $barber->id)
            ->with('categories')
            ->get();

        return SchedullingResource::collection($schedullings);
    }

    public function searchForDay(string $date)
    {
        return SchedullingResource::collection(Schedulling::forDay($date)->get());
    }

    public function create(array $data, array $categories): SchedullingResource
    {
        $scheduling = Schedulling::createService($data);

        $scheduling->CalculateTotalService($categories);

        $scheduling->load('categories');

        return new SchedullingResource($scheduling);
    }

    public function update(string $id, array $data): SchedullingResource
    {
        $schedulling = Schedulling::findOrFail($id);

        $schedulling = $schedulling->updateSchedullingWithCategories(
            $data,
            $data['categories']
        );

        $schedulling->load('categories');

        return new SchedullingResource($schedulling);
    }

    public function conclude(string $id): void
    {
        $scheduling = Schedulling::findOrFail($id);

        if ($scheduling->status === 'Finalizado') {
            throw new \Exception('Esse agendamento já foi finalizado.');
        }

        $scheduling->update(['status' => 'Finalizado']);
    }

}



?>