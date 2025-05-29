<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BarberRequest;
use App\Http\Resources\BarberResource;
use App\Services\BarberService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class BarberController extends Controller
{
    protected $barberService;

    public function __construct(BarberService $barberService)
    {
        $this->barberService = $barberService;
    }

    public function index()
    {
        $barbers = $this->barberService->getAll();
        return response()->json($barbers);
    }

    public function getActiveBarbers()
    {
        return $this->barberService->getActive();
    }

    public function getInactiveBarbers()
    {
        return $this->barberService->getInactive();
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
    
            $barbers = $this->barberService->searchByNameOrCpf($keyword);
    
            if ($barbers->isEmpty()) {
                return response()->json([
                    'message' => 'Nenhum barbeiro encontrado.'
                ], 404);
            }
    
            return response()->json($barbers);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro interno ao buscar barbeiro.',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function store(BarberRequest $request) 
    {
        try {
            $barber = $this->barberService->create($request->validated());

            Log::info('Novo barbeiro cadastrado com sucesso.', [
                'barber_id' => $barber->id,
                'user' => Auth::user()->name, 
                'data' => $request->validated()
            ]);

            return response()->json(new BarberResource($barber), 201);
        } catch (\Exception $e) {
            Log::error('Erro ao cadastrar barbeiro.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request,
                'user' => Auth::user()->name
            ]);
        }
    }

    public function show(string $id)
    {
        try {
            $barber = $this->barberService->getById($id);
            return new BarberResource($barber);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Barbeiro não encontrado.'], 404);
        }
    }

    public function update(BarberRequest $request, string $id) // Criar um BarberUpdateRequest
    {
        try {
            $barber = $this->barberService->update($id, $request->validated());

            Log::info('Barbeiro atualizado com sucesso.', [
            'barber_id' => $barber->id,
            'user' => Auth::user()->name,
            'data' => $request->validated()
            ]);

            return response()->json(new BarberResource($barber));
        } catch (ModelNotFoundException $e) {
            Log::warning('Tentativa de atualizar barbeiro não encontrado.', [
                    'barber_id' => $id,
                    'user' => Auth::user()->name 
            ]);

            return response()->json(['message' => 'Barbeiro não encontrado!'], 404);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->barberService->delete($id);

            Log::info('Barbeiro deletado com sucesso.', [
            'barber_id' => $id,
            'user' => Auth::user()->name 
            ]);

            return response()->json('Barbeiro deletado com sucesso', 204);
        } catch (ModelNotFoundException $e) {

            Log::warning('Tentativa de deletar barbeiro não encontrado.', [
            'barber_id' => $id,
            'user_id' => Auth::user()->name
            ]);
            return response()->json(['status' => false, 'message' => 'Barbeiro não encontrado.'], 404);
        }
    }
}
