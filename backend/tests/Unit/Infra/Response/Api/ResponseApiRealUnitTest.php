<?php

namespace Tests\Unit\Infra\Response\Api;

use App\Infra\Response\Api\ResponseApiReal;
use App\Infra\Response\Enum\HttpStatusCodeEnum;
use Mockery;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\UnitTestCase;

class ResponseApiRealUnitTest extends UnitTestCase
{
    #[TestDox("Testando com array no response do data")]
    public function testMakeDataTestOne()
    {
        $response = Mockery::mock(ResponseApiReal::class)->makePartial();
        $response->shouldAllowMockingProtectedMethods();

        $result = $response->makeData(['key' => 'value'], HttpStatusCodeEnum::HttpAccepted);

        $this->assertEquals([
            'status' => HttpStatusCodeEnum::HttpAccepted->value,
            'data' => ['key' => 'value'],
        ], $result);
    }

    #[TestDox("Testando com null no response do data")]
    public function testMakeDataTestTwo()
    {
        $response = Mockery::mock(ResponseApiReal::class)->makePartial();
        $response->shouldAllowMockingProtectedMethods();

        $result = $response->makeData(null, HttpStatusCodeEnum::HttpAccepted);

        $this->assertEquals([
            'status' => HttpStatusCodeEnum::HttpAccepted->value,
            'data' => null,
        ], $result);
    }

    #[TestDox("Testando com string no response do data")]
    public function testMakeDataTestThree()
    {
        $response = Mockery::mock(ResponseApiReal::class)->makePartial();
        $response->shouldAllowMockingProtectedMethods();

        $result = $response->makeData('teste', HttpStatusCodeEnum::HttpAccepted);

        $this->assertEquals([
            'status' => HttpStatusCodeEnum::HttpAccepted->value,
            'data' => 'teste',
        ], $result);
    }

    public function testRenderCreated()
    {
        $response = new ResponseApiReal();
        $result = $response->renderCreated();

        $this->assertEquals(HttpStatusCodeEnum::HttpCreated->value, $result->getStatusCode());
        $this->assertEquals([
            'status' => HttpStatusCodeEnum::HttpCreated->value,
            'data' => null,
        ], json_decode($result->getContent(), true));
    }

    public function testRenderOk()
    {
        $response = new ResponseApiReal();
        $result = $response->renderOk(['key' => 'value']);

        $this->assertEquals(HttpStatusCodeEnum::HttpOk->value, $result->getStatusCode());
        $this->assertEquals([
            'status' => HttpStatusCodeEnum::HttpOk->value,
            'data' => ['key' => 'value'],
        ], json_decode($result->getContent(), true));
    }

    public function testRenderNoContent()
    {
        $response = new ResponseApiReal();
        $result = $response->renderNoContent();

        $this->assertEquals(HttpStatusCodeEnum::HttpNoContent->value, $result->getStatusCode());
        $this->assertEquals([
            'status' => HttpStatusCodeEnum::HttpNoContent->value,
            'data' => null,
        ], json_decode($result->getContent(), true));
    }

    public function testRenderUnauthorized()
    {
        $response = new ResponseApiReal();
        $result = $response->renderUnauthorized();

        $this->assertEquals(HttpStatusCodeEnum::HttpUnauthorized->value, $result->getStatusCode());
        $this->assertEquals([
            'status' => HttpStatusCodeEnum::HttpUnauthorized->value,
            'data' => null,
        ], json_decode($result->getContent(), true));
    }

    public function testRenderNotFound()
    {
        $response = new ResponseApiReal();
        $result = $response->renderNotFount();

        $this->assertEquals(HttpStatusCodeEnum::HttpNotFound->value, $result->getStatusCode());
        $this->assertEquals([
            'status' => HttpStatusCodeEnum::HttpNotFound->value,
            'data' => 'Objeto não encontrado!',
        ], json_decode($result->getContent(), true));
    }

    public function testRenderBadRequest()
    {
        $response = new ResponseApiReal();
        $result = $response->renderBadRequest();

        $this->assertEquals(HttpStatusCodeEnum::HttpBadRequest->value, $result->getStatusCode());
        $this->assertEquals([
            'status' => HttpStatusCodeEnum::HttpBadRequest->value,
            'data' => null,
        ], json_decode($result->getContent(), true));
    }

    public function testRenderInternalServerError()
    {
        $response = new ResponseApiReal();
        $result = $response->renderInternalServerError('error');

        $this->assertEquals(HttpStatusCodeEnum::HttpInternalServerError->value, $result->getStatusCode());
        $this->assertEquals([
            'status' => HttpStatusCodeEnum::HttpInternalServerError->value,
            'data' => 'error',
        ], json_decode($result->getContent(), true));
    }
}
