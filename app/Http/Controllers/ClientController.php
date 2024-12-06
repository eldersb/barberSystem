<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        $client = Client::create($request->validated());

        return response()->json(new ClientResource($client), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $client = Client::findOrFail($id);
            return response()->json($client);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Cliente não encontrado.',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, string $id)
    {
        try{
            $client = Client::findOrFail($id);

            $client->update($request->validated());

            return response()->json(new ClientResource($client), 200);

        }catch(ModelNotFoundException $e) {
            return response()->json([
                'message' => "Cliente não encontrado!",
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) // Cliente com agendamento ativo não pode ser excluído 
    {
        try {
            $client = Client::findOrFail($id);

            $hasActiveSchedullings = $client->schedullings()->where('status', 'Em andamento')->exists();

            if ($hasActiveSchedullings) {
                return response()->json([
                    'error' => 'O cliente não pode ser excluído porque possui agendamentos ativos.'
                ], 400); 
            }

            $client->delete();
            
            return response()->json('Cliente deletado ccom sucesso', 204);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Barbeiro não encontrado.'
            ], 404);
        }
    }
}
