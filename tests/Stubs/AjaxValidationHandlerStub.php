<?php

declare(strict_types=1);

namespace Oguz\Tremmel\Tests\Stubs;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Oguz\Tremmel\Handlers\AjaxValidationHandler;
use Throwable;

class AjaxValidationHandlerStub extends AjaxValidationHandler
{
    protected function handle(Request $request, Throwable $exception): JsonResponse
    {
        return new JsonResponse([
            'success' => 'stub-handle-method-result'
        ]);
    }
}