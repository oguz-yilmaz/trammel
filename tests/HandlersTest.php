<?php 

declare(strict_types=1);

namespace Oguz\Tremmel\Tests;

use Oguz\Tremmel\Tests\Stubs\AjaxValidationHandlerStub;
use Oguz\Tremmel\Tests\Stubs\JsonValidationHandlerStub;
use Symfony\Component\HttpFoundation\HeaderBag;
use Illuminate\Validation\ValidationException;
use Oguz\Tremmel\Tests\Stubs\JsonHandlerStub;
use Oguz\Tremmel\Tests\Stubs\AjaxHandlerStub;
use PHPUnit\Framework\TestCase;
use Oguz\Tremmel\HandlersChain;
use Illuminate\Http\Request;
use Exception;

final class HandlersTest extends TestCase
{
    public function test_can_form_request_object()
    {
        $request = new Request(['test' => 'test']);

        $this->assertEquals($request->test, 'test');
    }

    public function test_can_form_json_request_object()
    {
        $request = $this->createJsonRequest();

        $this->assertTrue($request->isJson());
    }

    public function test_can_form_ajax_request_object()
    {
        $request = $this->createAjaxRequest();

        $this->assertTrue($request->ajax());
    }

    public function test_ajax_handler_should_handle_if_request_is_ajax()
    {
        $request = $this->createAjaxRequest();

        $chain = new HandlersChain();

        $ajaxHandler = new AjaxHandlerStub();

        $chain->registerHandler($ajaxHandler);

        $result = $chain->processChain($request, new Exception('test exception'));

        $responseMessage = json_decode($result->getContent(), true);

        $this->assertEquals($responseMessage['success'], 'ajax-stub-handle-method-result');
    }

    public function test_json_handler_should_handle_if_request_is_json()
    {
        $request = $this->createJsonRequest();

        $chain = new HandlersChain();

        $jsonHandler = new JsonHandlerStub();

        $chain->registerHandler($jsonHandler);

        $result = $chain->processChain($request, new Exception('test exception'));

        $responseMessage = json_decode($result->getContent(), true);

        $this->assertEquals($responseMessage['success'], 'json-stub-handle-method-result');
    }

    public function test_json_handler_should_run_before_even_if_exception_is_validation_exception_if_registered_before()
    {
        $request = $this->createJsonRequest();

        $exception = $this->createMock(ValidationException::class);

        $chain = new HandlersChain();

        $jsonHandler = new JsonHandlerStub();
        $jsonValidationHandler = new JsonValidationHandlerStub();

        $chain->registerHandler($jsonHandler);
        $chain->registerHandler($jsonValidationHandler);

        $result = $chain->processChain($request, $exception);

        $responseMessage = json_decode($result->getContent(), true);

        $this->assertEquals($responseMessage['success'], 'json-stub-handle-method-result');
    }

    public function test_ajax_handler_should_run_before_even_if_exception_is_validation_exception_if_registered_before()
    {
        $request = $this->createAjaxRequest();

        $exception = $this->createMock(ValidationException::class);

        $chain = new HandlersChain();

        $ajaxHandler = new AjaxHandlerStub();
        $ajaxValidationHandler = new AjaxValidationHandlerStub();

        $chain->registerHandler($ajaxHandler);
        $chain->registerHandler($ajaxValidationHandler);

        $result = $chain->processChain($request, $exception);

        $responseMessage = json_decode($result->getContent(), true);

        $this->assertEquals($responseMessage['success'], 'ajax-stub-handle-method-result');
    }

    public function test_ajax_validation_should_handle_validation_exceptions_if_request_is_ajax()
    {
        $request = $this->createAjaxRequest();

        $exception = $this->createMock(ValidationException::class);

        $chain = new HandlersChain();

        $ajaxValidationHandler = new AjaxValidationHandlerStub();

        $chain->registerHandler($ajaxValidationHandler);

        $result = $chain->processChain($request, $exception);

        $responseMessage = json_decode($result->getContent(), true);

        $this->assertEquals($responseMessage['success'], 'ajax-validation-stub-handle-method-result');
    }

    public function test_json_validation_should_handle_validation_exceptions_if_request_is_json()
    {
        $request = $this->createJsonRequest();

        $exception = $this->createMock(ValidationException::class);

        $chain = new HandlersChain();

        $jsonValidationHandler = new JsonValidationHandlerStub();

        $chain->registerHandler($jsonValidationHandler);

        $result = $chain->processChain($request, $exception);

        $responseMessage = json_decode($result->getContent(), true);

        $this->assertEquals($responseMessage['success'], 'json-validation-stub-handle-method-result');
    }

    public function test_processes_ajax_correctly_with_multiple_handler_registered()
    {
        $request = $this->createAjaxRequest();

        $exception = $this->createMock(ValidationException::class);

        $chain = new HandlersChain();

        $jsonValidationHandler = new JsonValidationHandlerStub();
        $ajaxValidationHandler = new AjaxValidationHandlerStub();

        $chain->registerHandler($jsonValidationHandler);
        $chain->registerHandler($ajaxValidationHandler);

        $result = $chain->processChain($request, $exception);

        $responseMessage = json_decode($result->getContent(), true);

        $this->assertEquals($responseMessage['success'], 'ajax-validation-stub-handle-method-result');
    }

    public function test_processes_json_correctly_with_multiple_handler_registered()
    {
        $request = $this->createJsonRequest();

        $exception = $this->createMock(ValidationException::class);

        $chain = new HandlersChain();

        $jsonValidationHandler = new JsonValidationHandlerStub();
        $ajaxValidationHandler = new AjaxValidationHandlerStub();

        $chain->registerHandler($ajaxValidationHandler);
        $chain->registerHandler($jsonValidationHandler);

        $result = $chain->processChain($request, $exception);

        $responseMessage = json_decode($result->getContent(), true);

        $this->assertEquals($responseMessage['success'], 'json-validation-stub-handle-method-result');
    }

    private function createAjaxRequest(array $data = []): Request
    {
        $request = new Request($data);

        $request->headers = new HeaderBag(['X-Requested-With' => 'XMLHttpRequest']);

        return $request;
    }

    private function createJsonRequest(array $data = []): Request
    {
        $request = new Request($data);

        $request->headers = new HeaderBag(['CONTENT_TYPE' => '+json']);

        return $request;
    }
}
