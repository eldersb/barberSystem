<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Auth\Events\Registered;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psy\Readline\Userland;

class RegisteredUserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAll();
        return response()->json($users);
    }

    public function store(UserRegisterRequest $request)
    {
       $user = $this->userService->registerUser($request->validated());

        event(new Registered($user));
        Auth::login($user);

        return response()->json([
            'message' => 'Usuário registrado com sucesso!',
        ], 201);
    }

    public function show(string $id)
    {
        try {
            $user = $this->userService->getById($id);
            return new UserResource($user);
        } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'Usuário não encontrado.'], 404);
        }
    }

    public function update(UserRegisterRequest $request, string $id)
    {
        try{
             $user = $this->userService->update($id, $request->validated());
            return response()->json(new UserResource($user), 200);

        } catch(ModelNotFoundException $e) {
            return response()->json([
                'message' => "Usuário não encontrado!",
            ], 404);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->userService->delete($id);
            return response()->json('Usuário deletado com sucesso', 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Usuário não encontrado.'], 404);
        }
    }
}
