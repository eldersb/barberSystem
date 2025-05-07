<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClientController extends Controller
{
     protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index()
    {
        $clients = $this->clientService->getAll();
        return response()->json($clients);
    }

    public function search(Request $request)
    {
        try {
            $keyword = $request->query('keyword');

            if (!$keyword) {
                return response()->json([
                    'message' => 'Parâmetro desconhecido.'
                ], 400);
            }
    
            $barbers = $this->clientService->searchByNameOrCpf($keyword);
    
            if ($barbers->isEmpty()) {
                return response()->json([
                    'message' => 'Nenhum cliente encontrado.'
                ], 404);
            }
    
            return response()->json($barbers);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro interno ao buscar cliente.',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function store(ClientRequest $request)
    {
        $client = $this->clientService->create($request->validated());
        return response()->json(new ClientResource($client), 201);
    }

    public function show(string $id)
    {
        try {
            $client = $this->clientService->getById($id);
            return new ClientResource($client);
            
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
