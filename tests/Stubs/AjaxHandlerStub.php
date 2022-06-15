<?php

declare(strict_types=1);

namespace Oguz\Tremmel\Tests\Stubs;

use Oguz\Tremmel\Handlers\AjaxHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class AjaxHandlerStub extends AjaxHandler
{
    protected function handle(Request $request, Throwable $exception): JsonResponse
    {
        return new JsonResponse([
            'success' => 'ajax-stub-handle-method-result'
        ]);
    }
}