<?php

declare(strict_types=1);

namespace Oguz\Trammel\Handlers;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Throwable;

class AjaxValidationHandler extends AbstractHandler
{
    protected function isResponsible(Request $request, Throwable $exception): bool
    {
        return $request->ajax() && $exception instanceof ValidationException;
    }

    protected function handle(Request $request, Throwable $exception): Response
    {
        return $this->defaultValidationExceptionResponse($exception);
    }
}
