<?php
// app/Exception/Handler.php

declare(strict_types=1);

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Oguz\Tremmel\Handlers\AjaxHandler;
use Oguz\Tremmel\Handlers\AjaxValidationHandler;
use Oguz\Tremmel\Handlers\HandlersChain;
use Oguz\Tremmel\Handlers\JsonHandler;
use Oguz\Tremmel\Handlers\JsonValidationHandler;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        $chain = new HandlersChain();

        $chain->registerHandler(new AjaxValidationHandler());
        $chain->registerHandler(new AjaxHandler());
        $chain->registerHandler(new JsonValidationHandler());
        $chain->registerHandler(new JsonHandler());

        return $chain->processChain($request, $e) ?? parent::render($request, $e);
    }
}
