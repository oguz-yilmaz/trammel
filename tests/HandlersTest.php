<?php 

declare(strict_types=1);

namespace Oguz\Tremmel\Tests;

use Oguz\Tremmel\HandlersChain;
use Oguz\Tremmel\Tests\Stubs\AjaxValidationHandlerStub;
use Symfony\Component\HttpFoundation\HeaderBag;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\TestCase;
use Illuminate\Http\Request;

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

    public function test_ajax_validation_should_handle_validation_exceptions_if_request_is_ajax()
    {
        $request = $this->createAjaxRequest();

        $exception= $this->createMock(ValidationException::class);

        $chain = new HandlersChain();

        $ajaxValidationHandler = new AjaxValidationHandlerStub();

        $chain->registerHandler($ajaxValidationHandler);
        $result = $chain->processChain($request, $exception);

        $responseMessage = json_decode($result->getContent(), true);

        $this->assertEquals($responseMessage['success'], 'stub-handle-method-result');
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
