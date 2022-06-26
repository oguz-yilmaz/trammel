<?php

declare(strict_types=1);

namespace App\Exceptions\Handlers;

use Symfony\Component\HttpFoundation\Response;
use Oguz\Trammel\Handlers\AjaxValidationHandler;
use Illuminate\Http\Request;
use Throwable;

class CustomAjaxValidationHandler extends AjaxValidationHandler
{
    protected function handle(Request $request, Throwable $exception): Response
    {
        return response()->json([
            'success' => false,
            'message' => 'Custom Ajax validation handler'
        ]);
    }
}
