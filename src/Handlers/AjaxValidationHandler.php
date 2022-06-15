<?php

declare(strict_types=1);

namespace Oguz\Tremmel\Handlers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AjaxValidationHandler extends AbstractHandler
{
    protected function isResponsible(Request $request, Throwable $exception): bool
    {
        return $request->ajax() && $exception instanceof ValidationException;
    }

    protected function handle(Request $request, Throwable $exception): JsonResponse
    {
        $errors = [];

        foreach ($exception->errors() as $errs) {
            $errors[] = array_pop($errs);
        }

        $response = new JsonResponse([
            'validationErrors' => $errors,
            'errorMessage' => 'Invalid request',
            'ajaxFormErrors' => $this->getAjaxFormErrors($exception)
        ]);

        return $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function getAjaxFormErrors(Throwable $exception): array|string
    {
        $errors = [];

        try {
            $validatorBag = $exception->validator->errors();
            $inputNames = $validatorBag->keys();

            foreach ($inputNames as $inputName) {
                $inputErrors = $validatorBag->get($inputName);

                foreach ($inputErrors as $inputError) {
                    $errors[$inputName][] = $inputError;
                }
            }

            return $errors;
        }
        catch (Throwable $t) {
            return _t('Something went wrong');
        }
    }
}
