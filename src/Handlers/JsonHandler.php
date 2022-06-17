<?php

declare(strict_types=1);

namespace Oguz\Trammel\Handlers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class JsonHandler extends AbstractHandler
{
    protected function isResponsible(Request $request, Throwable $exception): bool
    {
        return $request->isJson();
    }

    protected function handle(Request $request, Throwable $exception): JsonResponse
    {
        return $this->defaultExceptionResponse($exception);
    }
}
