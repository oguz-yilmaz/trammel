<?php

declare(strict_types=1);

namespace Oguz\Tremmel\Handlers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class AjaxValidationHandler extends AbstractHandler
{
    protected function isResponsible(Request $request, Throwable $exception): bool
    {
        return $request->ajax() && $exception instanceof ValidationException;
    }

    protected function handle(Request $request, Throwable $exception): JsonResponse
    {
        return $this->defaultValidationExceptionResponse($exception);
    }
}
