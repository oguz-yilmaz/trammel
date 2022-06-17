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
`composer install oguz-yilmaz/trammel`

## Exception handler types

Trammel provides generic handlers for most situation. Each handler provides generic 
output formats that can be extended. See below for what they refer and what they offer as response
format.

- [Validation Exception Handler](../docs/handlers/validation.md).
- [Ajax Exception Handler](../docs/handlers/ajax.md).
- [Json Exception Handler](../docs/handlers/json.md).
- [Ajax Validation Exception Handler](../docs/handlers/ajax-validation.md).
- [Json Validation Exception Handler](../docs/handlers/json-validation.md).

## Usage  

If you want to use default handlers you can simply extend `Handler` class with 
Trammel's `BaseHandler` class in `app/Exception` folder.  

