<?php

declare(strict_types=1);

namespace Oguz\Tremmel\Handlers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class JsonHandler extends AbstractHandler
{
    protected function isResponsible(Request $request, Throwable $exception): bool
    {
        return $request->isJson();
    }

    protected function handle(Request $request, Throwable $exception): JsonResponse
    {
        $response = app(JsonResponse::class);

        return $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->setData([
                'successful' => false,
                'message' => $exception->getMessage()
            ]);
    }
}
