<?php

declare(strict_types=1);

namespace Oguz\Trammel\Exception;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Oguz\Trammel\Handlers\AjaxValidationHandler;
use Oguz\Trammel\Handlers\JsonValidationHandler;
use Oguz\Trammel\Handlers\ValidationHandler;
use Oguz\Trammel\Handlers\HandlersChain;
use Oguz\Trammel\Handlers\AjaxHandler;
use Oguz\Trammel\Handlers\JsonHandler;
use Throwable;

class BaseHandler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        $chain = new HandlersChain();

        $chain->registerHandler(new AjaxValidationHandler());
        $chain->registerHandler(new JsonValidationHandler());
        $chain->registerHandler(new AjaxHandler());
        $chain->registerHandler(new JsonHandler());
        $chain->registerHandler(new ValidationHandler());

        return $chain->processChain($request, $e) ?? parent::render($request, $e);
    }
}
