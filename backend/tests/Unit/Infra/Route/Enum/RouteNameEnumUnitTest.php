<?php

namespace Tests\Unit\Infra\Route\Enum;

use App\Infra\Route\Enum\RouteNameEnum;
use Tests\UnitTestCase;

class RouteNameEnumUnitTest extends UnitTestCase
{
    public function testEnum()
    {
        $this->assertEquals('api.auth.login', RouteNameEnum::ApiAuthLogin->value);

        $this->assertEquals('api.wallet.create', RouteNameEnum::ApiWalletCreate->value);
        $this->assertEquals('api.wallet.update', RouteNameEnum::ApiWalletUpdate->value);
        $this->assertEquals('api.wallet.delete', RouteNameEnum::ApiWalletDelete->value);
        $this->assertEquals('api.wallet.get', RouteNameEnum::ApiWalletGet->value);
        $this->assertEquals('api.wallet.list', RouteNameEnum::ApiWalletList->value);

        $this->assertEquals('api.movement.create', RouteNameEnum::ApiMovementCreate->value);
        $this->assertEquals('api.movement.update', RouteNameEnum::ApiMovementUpdate->value);
    }
}
