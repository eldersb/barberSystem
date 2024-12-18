<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchedullingRequest;
use App\Http\Resources\SchedullingResource;
use App\Models\Barber;
use App\Models\Schedulling;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SchedullingController extends Controller
{
    
    public function index()
    {
        $schedullings = Schedulling::all();

        $schedullings->load('categories');

        return response()->json(SchedullingResource::collection($schedullings));
    }

    public function indexByBarberName($barberName)
    {
        $barber = Barber::where('name', 'like', '%' . $barberName . '%')->first();

        if (!$barber) {
            return response()->json(['message' => 'Barbeiro não encontrado'], 404);
        }

        $schedullings = Schedulling::where('barber_id', $barber->id)->get();

        $schedullings->load('categories');

        return response()->json(SchedullingResource::collection($schedullings));
    }

    public function store(SchedullingRequest $request)
    {
        try {
            $schedulling = Schedulling::createService($request->validated());
    
            $schedulling->CalculateTotalService($request->categories);
    
            $schedulling->load('categories');
    
            return response()->json(new SchedullingResource($schedulling), 201);
    
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

    }
    
    public function show(string $id)
    {
        try {
            $schedulling = Schedulling::findOrFail($id);

            $schedulling->load('categories');

            return response()->json(new SchedullingResource($schedulling));
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Agendamento não encontrado.',
            ], 404);
        }
    }

    public function update(SchedullingRequest $request, string $id)
    {
        try {       
            $schedulling = Schedulling::findOrFail($id);

            $schedulling = $schedulling->updateSchedullingWithCategories(
                $request->validated(), 
                $request->categories
            );

            $schedulling->load('categories');

            return response()->json(new SchedullingResource($schedulling), 200);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Agendamento não encontrado!",
            ], 404);
        }
    }

    public function destroy(string $id)
    {
        try {
            $schedulling = Schedulling::findOrFail($id);
            $schedulling->delete();
            
            return response()->json('Agendamento deletado com sucesso!', 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Agendamento não encontrado.'
            ], 404);
        }
    }
}