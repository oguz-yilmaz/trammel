<?php

declare(strict_types=1);

namespace Oguz\Trammel\Exception;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Oguz\Trammel\Handlers\AjaxValidationHandler;
use Oguz\Trammel\Handlers\JsonValidationHandler;
use Oguz\Trammel\Handlers\ValidationHandler;
use Oguz\Trammel\HandlersChain;
use Oguz\Trammel\Handlers\AjaxHandler;
use Oguz\Trammel\Handlers\JsonHandler;
use Throwable;

class BaseHandler extends ExceptionHandler
{
    protected array $handlers = [];

    private array $defaultHandlers = [
        AjaxValidationHandler::class,
        JsonValidationHandler::class,
        AjaxHandler::class,
        JsonHandler::class,
        ValidationHandler::class,
    ];

    public function render($request, Throwable $e)
    {
        $chain = new HandlersChain();

        foreach ($this->defaultHandlers as $defaultHandler => $v) {
            $handler = $defaultHandler;

            if (in_array($defaultHandler, $this->handlers)) {
                $handlerKey = array_search($defaultHandler, $this->handlers);

                $handler = $this->handlers[$handlerKey];
            }

            $chain->registerHandler(new $handler);
        }

        return $chain->processChain($request, $e) ?? parent::render($request, $e);
    }
}
