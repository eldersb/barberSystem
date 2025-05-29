<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

          Log::info('Novo cliente cadastrado.', [
            'client_id' => $client->id,
            'user' => Auth::user()->name, 
            'category' => $request->validated()
        ]);

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

    public function update(ClientRequest $request, string $id)
    {
        try{
             $client = $this->clientService->update($id, $request->validated());

              Log::info('Cliente atualizado com sucesso.', [
                'client_id' => $client->id,
                'user' => Auth::user()->name,
                'data' => $request->validated()
            ]);

            return response()->json(new ClientResource($client), 200);

        }catch(ModelNotFoundException $e) {

             Log::warning('Tentativa de atualizar a cliente não encontrado.', [
                'category_id' => $id,
                'user' => Auth::user()->name 
            ]);

            return response()->json([
                'message' => "Cliente não encontrado!",
            ], 404);
        }
    }

   
    public function destroy(string $id) // Cliente com agendamento ativo não pode ser excluído 
    {
        try {
            $client = Client::findOrFail($id);

            $hasActiveSchedulings = $client->schedulings()->where('status', 'Em andamento')->exists();

            if ($hasActiveSchedulings) {
                return response()->json([
                    'error' => 'O cliente não pode ser excluído porque possui agendamentos ativos.'
                ], 400); 
            }

            $client->delete();

             Log::info('Cliente deletado com sucesso.', [
            'client_id' => $id,
            'user' => Auth::user()->name 
            ]);
            
            return response()->json('Cliente deletado ccom sucesso', 204);
            
        } catch (ModelNotFoundException $e) {

            Log::warning('Tentativa de deletar cliente não encontrado.', [
            'category_id' => $id,
            'user_id' => Auth::user()->name 
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Cliente não encontrado.'
            ], 404);
        }
    }
}
