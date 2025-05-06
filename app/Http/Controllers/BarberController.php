<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BarberRequest;
use App\Http\Resources\BarberResource;
use App\Services\BarberService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
                'message' => 'Erro interno ao buscar categoria.',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function store(BarberRequest $request) // Corrigir erro, pois o retorno da json está vindo "Inativo"
    {

        $barber = $this->barberService->create($request->validated());
        return response()->json(new BarberResource($barber), 201);
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

    public function update(BarberRequest $request, string $id)
    {
        try {
            $barber = $this->barberService->update($id, $request->validated());
            return response()->json(new BarberResource($barber));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Barbeiro não encontrado!'], 404);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->barberService->delete($id);
            return response()->json('Barbeiro deletado com sucesso', 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Barbeiro não encontrado.'], 404);
        }
    }
}
