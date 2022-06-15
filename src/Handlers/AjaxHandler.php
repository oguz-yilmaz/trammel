<?php

declare(strict_types=1);

namespace Oguz\Tremmel\Handlers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class AjaxHandler extends AbstractHandler
{
    protected function isResponsible(Request $request, Throwable $exception): bool
    {
        return $request->ajax();
    }

    protected function handle(Request $request, Throwable $exception): JsonResponse
    {
        return $this->defaultExceptionResponse($exception);
    }
}
