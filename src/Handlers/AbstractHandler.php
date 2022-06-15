<?php

declare(strict_types=1);

namespace Oguz\Tremmel\Handlers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

abstract class AbstractHandler
{
    protected ?AbstractHandler $nextHandler = null;

    public function process(Request $request, Throwable $exception): Response|JsonResponse|null
    {
        if ($this->isResponsible($request, $exception)) {
            return $this->handle($request, $exception);
        }

        return $this->nextHandler?->process($request, $exception);
    }

    public function registerNextHandler(AbstractHandler $handler)
    {
        if ($this->nextHandler instanceof AbstractHandler) {
            $this->nextHandler->registerNexthandler($handler);
        }
        else {
            $this->nextHandler = $handler;
        }
    }

    abstract protected function isResponsible(Request $request, Throwable $exception): bool;

    abstract protected function handle(Request $request, Throwable $exception): Response|JsonResponse;
}
