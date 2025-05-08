<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchedulingRequest;
use App\Http\Resources\SchedulingResource;
use App\Models\Scheduling;
use App\Services\SchedulingService;
use Dotenv\Exception\ValidationException;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class SchedulingController extends Controller
{

    protected $schedulingService;

    public function __construct(SchedulingService $schedulingService)
    {
        $this->schedulingService = $schedulingService;
    }
    
    public function index()
    {
        return response()->json($this->schedulingService->getAll());

    }

    public function indexByBarberName($barberName)
    {
        $schedullings = $this->schedulingService->getByBarberName($barberName);

        if (!$schedullings) {
            return response()->json(['message' => 'Barbeiro não encontrado'], 404);
        }

        return response()->json($schedullings);
    }

    public function searchForDay($data)
    {
        try {
            $schedullings = $this->schedulingService->searchForDay($data);

            return response()->json($schedullings);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao processar a data'], 400);
        }
    }

    public function store(SchedulingRequest $request)
    {
        try {
            $schedulingResource = $this->schedulingService->create(
                $request->validated(),
                $request->validated()['categories']
            );
    
            return response()->json($schedulingResource, 201);
    
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

    }
    
    public function show(string $id)
    {
        try {
            $schedulling = $this->schedulingService->getById($id);
            return response()->json($schedulling);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Agendamento não encontrado.',
            ], 404);
        }
    }

    public function update(SchedulingRequest $request, string $id)
    {
        try {       
            $schedullingResource = $this->schedulingService->update(
                $id,
                $request->validated()
            );
    
            return response()->json($schedullingResource, 200);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Agendamento não encontrado!",
            ], 404);
        }
    }

    public function destroy(string $id)
    {
        try {
            $schedulling = Scheduling::findOrFail($id);

            if ($schedulling->status === 'Finalizado') {
                return response()->json([
                    'message' => 'Não é possível excluir um agendamento que foi baixado.' 
                ], 400); 
            }

            $schedulling->delete();
            
            return response()->json('Agendamento deletado com sucesso!', 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Agendamento não encontrado.'
            ], 404);
        }
    }

    public function concludeScheduling($id)
    {
        try {
            $this->schedulingService->conclude($id);

            return response()->json(['message' => 'Agendamento finalizado com sucesso.']);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Agendamento não encontrado.'
            ], 404);
        } 

    }

   
}
