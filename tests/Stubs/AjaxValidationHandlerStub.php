<?php

declare(strict_types=1);

namespace Oguz\Trammel\Tests\Stubs;

use Oguz\Trammel\Handlers\AjaxValidationHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class AjaxValidationHandlerStub extends AjaxValidationHandler
{
    protected function handle(Request $request, Throwable $exception): JsonResponse
    {
        return new JsonResponse([
            'success' => 'ajax-validation-stub-handle-method-result'
        ]);
    }
}