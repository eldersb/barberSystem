<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarberRequest;
use App\Http\Resources\BarberResource;
use App\Models\Barber;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BarberController extends Controller
{

    public function index(Request $request)
    {
        $barbers = Barber::all();
        return response()->json($barbers);

        // return BarberResource::collection($barbers);
    }

    public function store(BarberRequest $request)
    {
        $barber = Barber::create($request->validated()); 

        return response()->json(new BarberResource($barber), 201);
    }

    public function show(string $id)
    {
        try {
            $barber = Barber::findOrFail($id);
            return response()->json($barber);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Barbeiro não encontrado.',
            ], 404);
        }
    }

    public function update(BarberRequest $request, string $id)
    {

        try{
            $barber = Barber::findOrFail($id);

            $barber->update($request->validated());

            return response()->json(new BarberResource($barber), 200);

        }catch(ModelNotFoundException $e) {
            return response()->json([
                'message' => "Barbeiro não encontrado !",
            ], 404);
        }
        // $barber = Barber::findOrFail($id);

        // $barber->update($request->validated());

        // return response()->json(new BarberResource($barber), 200);
    }

    public function destroy(string $id)
    {

        try {
            $barber = Barber::findOrFail($id);
            $barber->delete();
            
            return response()->json('Barbeiro deletado ccom sucesso', 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Barbeiro não encontrado.'
            ], 404);
        }

        // $barber = Barber::findOrFail($id);

        // $barber->delete();
    
        // return response()->json(null, 204);
    }
}
