<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            Log::warning('Erro de validação.', [
                'errors' => $exception->errors(),
                'user' => Auth::user()->name,
                'input' => $request->all()
            ]);
        }

        return parent::render($request, $exception);
    }
}
