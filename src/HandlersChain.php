<?php

declare(strict_types=1);

namespace Oguz\Tremmel;

use Illuminate\Http\Request;
use Oguz\Tremmel\Handlers\AbstractHandler;
use Throwable;

class HandlersChain
{
    private ?AbstractHandler $entrypoint = null;

    public function registerHandler(AbstractHandler $handler): void
    {
        if ($this->entrypoint instanceof AbstractHandler) {
            $this->entrypoint->registerNextHandler($handler);
        }
        else {
            $this->entrypoint = $handler;
        }
    }

    public function processChain(Request $request, Throwable $exception)
    {
        return $this->entrypoint->process($request, $exception);
    }
}
