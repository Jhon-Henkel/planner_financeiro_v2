<?php

namespace Tests\Unit\Infra\Response\Enum;

use App\Infra\Response\Enum\HttpStatusCodeEnum;
use Tests\UnitTestCase;

class HttpStatusCodeEnumUnitTest extends UnitTestCase
{
    public function testEnum()
    {
        $this->assertEquals(100, HttpStatusCodeEnum::HttpContinue->value);
        $this->assertEquals(101, HttpStatusCodeEnum::HttpSwitchingProtocols->value);
        $this->assertEquals(102, HttpStatusCodeEnum::HttpProcessing->value);
        $this->assertEquals(103, HttpStatusCodeEnum::HttpEarlyHints->value);
        $this->assertEquals(200, HttpStatusCodeEnum::HttpOk->value);
        $this->assertEquals(201, HttpStatusCodeEnum::HttpCreated->value);
        $this->assertEquals(202, HttpStatusCodeEnum::HttpAccepted->value);
        $this->assertEquals(203, HttpStatusCodeEnum::HttpNonAuthoritativeInformation->value);
        $this->assertEquals(204, HttpStatusCodeEnum::HttpNoContent->value);
        $this->assertEquals(205, HttpStatusCodeEnum::HttpResetContent->value);
        $this->assertEquals(206, HttpStatusCodeEnum::HttpPartialContent->value);
        $this->assertEquals(207, HttpStatusCodeEnum::HttpMultiStatus->value);
        $this->assertEquals(208, HttpStatusCodeEnum::HttpAlreadyReported->value);
        $this->assertEquals(226, HttpStatusCodeEnum::HttpImUsed->value);
        $this->assertEquals(300, HttpStatusCodeEnum::HttpMultipleChoices->value);
        $this->assertEquals(301, HttpStatusCodeEnum::HttpMovedPermanently->value);
        $this->assertEquals(302, HttpStatusCodeEnum::HttpFound->value);
        $this->assertEquals(303, HttpStatusCodeEnum::HttpSeeOther->value);
        $this->assertEquals(304, HttpStatusCodeEnum::HttpNotModified->value);
        $this->assertEquals(305, HttpStatusCodeEnum::HttpUseProxy->value);
        $this->assertEquals(306, HttpStatusCodeEnum::HttpReserved->value);
        $this->assertEquals(307, HttpStatusCodeEnum::HttpTemporaryRedirect->value);
        $this->assertEquals(308, HttpStatusCodeEnum::HttpPermanentlyRedirect->value);
        $this->assertEquals(400, HttpStatusCodeEnum::HttpBadRequest->value);
        $this->assertEquals(401, HttpStatusCodeEnum::HttpUnauthorized->value);
        $this->assertEquals(402, HttpStatusCodeEnum::HttpPaymentRequired->value);
        $this->assertEquals(403, HttpStatusCodeEnum::HttpForbidden->value);
        $this->assertEquals(404, HttpStatusCodeEnum::HttpNotFound->value);
        $this->assertEquals(405, HttpStatusCodeEnum::HttpMethodNotAllowed->value);
        $this->assertEquals(406, HttpStatusCodeEnum::HttpNotAcceptable->value);
        $this->assertEquals(407, HttpStatusCodeEnum::HttpProxyAuthenticationRequired->value);
        $this->assertEquals(408, HttpStatusCodeEnum::HttpRequestTimeout->value);
        $this->assertEquals(409, HttpStatusCodeEnum::HttpConflict->value);
        $this->assertEquals(410, HttpStatusCodeEnum::HttpGone->value);
        $this->assertEquals(411, HttpStatusCodeEnum::HttpLengthRequired->value);
        $this->assertEquals(412, HttpStatusCodeEnum::HttpPreconditionFailed->value);
        $this->assertEquals(413, HttpStatusCodeEnum::HttpRequestEntityTooLarge->value);
        $this->assertEquals(414, HttpStatusCodeEnum::HttpRequestUriTooLong->value);
        $this->assertEquals(415, HttpStatusCodeEnum::HttpUnsupportedMediaType->value);
        $this->assertEquals(416, HttpStatusCodeEnum::HttpRequestedRangeNotSatisfiable->value);
        $this->assertEquals(417, HttpStatusCodeEnum::HttpExpectationFailed->value);
        $this->assertEquals(418, HttpStatusCodeEnum::HttpIAmATeapot->value);
        $this->assertEquals(421, HttpStatusCodeEnum::HttpMisdirectedRequest->value);
        $this->assertEquals(422, HttpStatusCodeEnum::HttpUnprocessableEntity->value);
        $this->assertEquals(423, HttpStatusCodeEnum::HttpLocked->value);
        $this->assertEquals(424, HttpStatusCodeEnum::HttpFailedDependency->value);
        $this->assertEquals(425, HttpStatusCodeEnum::HttpTooEarly->value);
        $this->assertEquals(426, HttpStatusCodeEnum::HttpUpgradeRequired->value);
        $this->assertEquals(428, HttpStatusCodeEnum::HttpPreconditionRequired->value);
        $this->assertEquals(429, HttpStatusCodeEnum::HttpTooManyRequests->value);
        $this->assertEquals(431, HttpStatusCodeEnum::HttpRequestHeaderFieldsTooLarge->value);
        $this->assertEquals(451, HttpStatusCodeEnum::HttpUnavailableForLegalReasons->value);
        $this->assertEquals(500, HttpStatusCodeEnum::HttpInternalServerError->value);
        $this->assertEquals(501, HttpStatusCodeEnum::HttpNotImplemented->value);
        $this->assertEquals(502, HttpStatusCodeEnum::HttpBadGateway->value);
        $this->assertEquals(503, HttpStatusCodeEnum::HttpServiceUnavailable->value);
        $this->assertEquals(504, HttpStatusCodeEnum::HttpGatewayTimeout->value);
        $this->assertEquals(505, HttpStatusCodeEnum::HttpVersionNotSupported->value);
        $this->assertEquals(506, HttpStatusCodeEnum::HttpVariantAlsoNegotiatesExperimental->value);
        $this->assertEquals(507, HttpStatusCodeEnum::HttpInsufficientStorage->value);
        $this->assertEquals(508, HttpStatusCodeEnum::HttpLoopDetected->value);
        $this->assertEquals(510, HttpStatusCodeEnum::HttpNotExtended->value);
        $this->assertEquals(511, HttpStatusCodeEnum::HttpNetworkAuthenticationRequired->value);
    }
}
