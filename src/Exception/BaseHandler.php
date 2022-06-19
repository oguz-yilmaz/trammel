<?php

declare(strict_types=1);

namespace Oguz\Trammel\Exception;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Oguz\Trammel\Handlers\AjaxValidationHandler;
use Oguz\Trammel\Handlers\JsonValidationHandler;
use Symfony\Component\HttpFoundation\Response;
use Oguz\Trammel\Handlers\ValidationHandler;
use Oguz\Trammel\Handlers\AjaxHandler;
use Oguz\Trammel\Handlers\JsonHandler;
use Oguz\Trammel\HandlersChain;
use ReflectionClass;
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

    public function render($request, Throwable $e): Response
    {
        $chain = new HandlersChain();

        foreach ($this->defaultHandlers as $defaultHandler) {
            $formattedHandlers = $this->reformatUserHandlersArray();

            $handler = $formattedHandlers[$defaultHandler] ?? $defaultHandler;

            $chain->registerHandler(new $handler);
        }

        return $chain->processChain($request, $e) ?? parent::render($request, $e);
    }

    public function reformatUserHandlersArray(): array
    {
        $formatted = [];

        foreach ($this->handlers as $handler) {
            $reflection = new ReflectionClass($handler);

            $parentHandler = $reflection->getParentClass()->getName();

            $formatted[$parentHandler] = $handler;
        }
        
        return $formatted;
    }
}
