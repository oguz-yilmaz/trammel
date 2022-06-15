<?php

declare(strict_types=1);

namespace Oguz\Tremmel\Handlers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class JsonValidationHandler extends AbstractHandler
{
    protected function isResponsible(Request $request, Throwable $exception): bool
    {
        return $request->isJson() && $exception instanceof ValidationException;
    }

    protected function handle(Request $request, Throwable $exception): JsonResponse
    {
        $response = app(JsonResponse::class);

        foreach ($exception->errors() as $errs) {
            $errors[] = array_pop($errs);
        }

        return $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->setData([
                'successful' => false,
                'code' => 'internal_error',
                'message' => implode(PHP_EOL, $errors ?? ['Something went wrong']),
            ]);
    }
}
