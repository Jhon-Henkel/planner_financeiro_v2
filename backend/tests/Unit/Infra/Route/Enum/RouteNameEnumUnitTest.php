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
        $this->assertEquals('api.wallet.details', RouteNameEnum::ApiWalletDetails->value);

        $this->assertEquals('api.movement.create', RouteNameEnum::ApiMovementCreate->value);
        $this->assertEquals('api.movement.update', RouteNameEnum::ApiMovementUpdate->value);
        $this->assertEquals('api.movement.delete', RouteNameEnum::ApiMovementDelete->value);
        $this->assertEquals('api.movement.get', RouteNameEnum::ApiMovementGet->value);
        $this->assertEquals('api.movement.list', RouteNameEnum::ApiMovementList->value);

        $this->assertEquals('api.movement.transfer.delete', RouteNameEnum::ApiMovementTransferDelete->value);
        $this->assertEquals('api.movement.transfer.create', RouteNameEnum::ApiMovementTransferCreate->value);

        $this->assertEquals('api.expense.create', RouteNameEnum::ApiExpenseCreate->value);
        $this->assertEquals('api.expense.pay', RouteNameEnum::ApiExpensePay->value);
        $this->assertEquals('api.expense.list', RouteNameEnum::ApiExpenseList->value);
    }
}
