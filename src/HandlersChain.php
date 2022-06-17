<?php

declare(strict_types=1);

namespace Oguz\Trammel;

use Oguz\Trammel\Handlers\AbstractHandler;
use Illuminate\Http\Request;
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
