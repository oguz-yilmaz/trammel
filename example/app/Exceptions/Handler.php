<?php

namespace App\Exceptions;

use App\Exceptions\Handlers\CustomAjaxHandler;
use App\Exceptions\Handlers\CustomAjaxValidationHandler;
use Oguz\Trammel\Exception\BaseHandler;

class Handler extends BaseHandler
{
    protected array $handlers = [
        CustomAjaxHandler::class,
        CustomAjaxValidationHandler::class
    ];

    // ...
}
