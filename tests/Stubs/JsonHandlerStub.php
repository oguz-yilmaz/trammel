<?php

declare(strict_types=1);

namespace Oguz\Trammel\Tests\Stubs;

use Oguz\Trammel\Handlers\JsonHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class JsonHandlerStub extends JsonHandler
{
    protected function handle(Request $request, Throwable $exception): JsonResponse
    {
        return new JsonResponse([
            'success' => 'json-stub-handle-method-result'
        ]);
    }
}