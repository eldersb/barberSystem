<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Auth\Events\Registered;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;



class RegisteredUserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
}
