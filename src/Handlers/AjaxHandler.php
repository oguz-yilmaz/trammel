<?php

declare(strict_types=1);

namespace Oguz\Tremmel\Handlers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class AjaxHandler extends AbstractHandler
{
    protected function isResponsible(Request $request, Throwable $exception): bool
    {
        return $request->ajax();
    }

    protected function handle(Request $request, Throwable $exception): JsonResponse
    {
        $response = app(JsonResponse::class);

        if ($exception instanceof ModelNotFoundException) {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        else {
            $response->setFatal($exception->getMessage());
        }

        return $response;
    }
}
