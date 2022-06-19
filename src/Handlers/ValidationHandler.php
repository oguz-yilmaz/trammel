<?php

declare(strict_types=1);

namespace Oguz\Trammel\Handlers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class ValidationHandler extends AbstractHandler
{
    protected function isResponsible(Request $request, Throwable $exception): bool
    {
        return $exception instanceof ValidationException;
    }

    protected function handle(Request $request, Throwable $exception): RedirectResponse
    {
        return redirect()->back()->withErrors($exception->errors())->withInput();
    }
}
