<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarberRequest;
use App\Http\Resources\BarberResource;
use App\Models\Barber;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BarberController extends Controller
{
   
    // private $barber;

    // public function __construct(Barber $barber)
    // {
    //     $this->barber = $barber;
    // }

    public function index(Request $request)
    {
        $barbers = Barber::all();
        return response()->json($barbers);

        // return BarberResource::collection($barbers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BarberRequest $request)
    {
        $barber = Barber::create($request->validated()); // Verificar erro de validação

        return response()->json(new BarberResource($barber), 201);
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
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
