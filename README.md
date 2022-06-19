### About Trammel 

Handling exceptions is vital for all sorts of applications. 
Making it right and standardized increases the quality of your application 
as well as making it easy to reason about. In laravel there is not much 
configuration you can apply and there is only one place where you construct 
all your exceptions, that is the `Handler.php`. With the need of custom exception handling
this file becomes pretty ugly real quick having if-else statements all over the place.This 
library provides default exception handling and standardized output formats for different
types of exceptions (`Validation exceptions`, `Ajax or Json exceptions` or `combined`) as well as
distict handlers for each where you can extend and customize.

## Installation  
`composer require oguz-yilmaz/trammel`

## Exception handler types and default output formats

Trammel provides generic handlers for most situation. Each handler provides generic 
output formats that can be extended. See below for what they refer and what they offer as response
format.

- [Validation Exception Handler](docs/handlers/validation.md).
- [Ajax Exception Handler](docs/handlers/ajax.md).
- [Json Exception Handler](docs/handlers/json.md).
- [Ajax Validation Exception Handler](docs/handlers/ajax-validation.md).
- [Json Validation Exception Handler](docs/handlers/json-validation.md).

## Usage  
  
### Default output formats

If you want to use default output formats you can simply extend `Handler` class with 
Trammel's `BaseHandler` class in `app/Exception` folder.  

```php
// app/Exception/Handler.php
use Oguz\Trammel\Exception\BaseHandler;

class Handler extends BaseHandler
{
    // if class has render method, remove it
}
```
### Customizing handlers  

if you don't want to use default behaviour of a handler, you can extend it. First let's create
a new folder under `app/Exception` called `Handlers` to keep our custom exception handlers.
This will make it more tidy and clean.

```php
<?php

namespace App\Exceptions\Handlers;

use Symfony\Component\HttpFoundation\Response;
use Oguz\Trammel\Handlers\AjaxHandler;
use Illuminate\Http\Request;
use Throwable;

class CustomAjaxHandler extends AjaxHandler
{
    protected function handle(Request $request, Throwable $exception): Response
    {
        return response()->json([
            'success' => true
        ]);
    }
}
```  
Then you need to add these custom exception handlers to `$handlers` property of the
`App\Exception\Handler` class comes from `Oguz\Trammel\Exception\BaseHandler` class.

```php
namespace App\Exceptions;

use App\Exceptions\Handlers\CustomAjaxHandler;
use Oguz\Trammel\Exception\BaseHandler;

class Handler extends BaseHandler
{
    protected array $handlers = [
        CustomAjaxHandler::class
    ];
    
    //...
}
```   

## How these exceptions will be triggered   

To get detailed information for each exception type, see 
[above](#exception-handler-types-and-default-output-formats).