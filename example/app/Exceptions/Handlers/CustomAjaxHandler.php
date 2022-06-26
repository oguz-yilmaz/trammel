<?php

declare(strict_types=1);

namespace App\Exceptions\Handlers;

use Symfony\Component\HttpFoundation\Response;
use Oguz\Trammel\Handlers\AjaxHandler;
use Illuminate\Http\Request;
use Throwable;

class CustomAjaxHandler extends AjaxHandler
{
    protected function handle(Request $request, Throwable $exception): Response
    {
        return response()->json([
            'success' => false,
            'message' => 'Custom Ajax handler'
        ]);
    }
}
