<?php

declare(strict_types=1);

namespace Oguz\Trammel\Handlers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Throwable;

class JsonHandler extends AbstractHandler
{
    protected function isResponsible(Request $request, Throwable $exception): bool
    {
        return $request->isJson();
    }

    protected function handle(Request $request, Throwable $exception): Response
    {
        return $this->defaultExceptionResponse($exception);
    }
}
