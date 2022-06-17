<?php

declare(strict_types=1);

namespace Oguz\Trammel\Handlers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class ValidationHandler extends AbstractHandler
{
    protected function isResponsible(Request $request, Throwable $exception): bool
    {
        return $exception instanceof ValidationException;
    }

    protected function handle(Request $request, Throwable $exception): Response
    {
        return response()->json($exception->errors());
    }
}
