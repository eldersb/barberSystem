<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchedullingRequest;
use App\Http\Resources\SchedullingResource;
use App\Models\Schedulling;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SchedullingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedullings = Schedulling::all();
        return response()->json($schedullings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchedullingRequest $request)
    {

        $schedulling = Schedulling::create($request->validated()); // Erro de validação

        return response()->json(new SchedullingResource($schedulling), 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $schedulling = Schedulling::findOrFail($id);
            return response()->json($schedulling);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Agendamento não encontrado.',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchedullingRequest $request, string $id)
    {
        try{
            $schedulling = Schedulling::findOrFail($id);

            $schedulling->update($request->validated());

            return response()->json(new SchedullingResource($schedulling), 200);

        }catch(ModelNotFoundException $e) {
            return response()->json([
                'message' => "Agendamento não encontrado!",
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
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
