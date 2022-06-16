<?php

declare(strict_types=1);

namespace Oguz\Tremmel\Exception;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Oguz\Tremmel\Handlers\AjaxValidationHandler;
use Oguz\Tremmel\Handlers\JsonValidationHandler;
use Oguz\Tremmel\Handlers\ValidationHandler;
use Oguz\Tremmel\Handlers\HandlersChain;
use Oguz\Tremmel\Handlers\AjaxHandler;
use Oguz\Tremmel\Handlers\JsonHandler;
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
