<?php

namespace Feature\Modules\Wallet\Controller;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Response\Enum\HttpStatusCodeEnum;
use App\Infra\Route\Enum\RouteNameEnum;
use App\Models\Wallet\Wallet;
use Tests\FeatureTestCase;

class WalletCreateControllerFeatureTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Wallet::where('name', 'PHP Unit Test Wallet')->delete();
    }

    protected function tearDown(): void
    {
        Wallet::where('name', 'PHP Unit Test Wallet')->delete();
        parent::tearDown();
    }

    public function testRoute()
    {
        $response = $this->postJson(route(RouteNameEnum::ApiWalletCreate), [
            'name' => 'PHP Unit Test Wallet',
            'amount' => 100,
            'hidden' => false,
        ], $this->makeHeaders());

        $response->assertStatus(HttpStatusCodeEnum::HttpCreated->value);

        $this->assertDatabaseHas(Wallet::class, [
            'name' =>  'PHP Unit Test Wallet',
            'amount' => 100,
            'hidden' => false,
            'status' => StatusActiveInactiveEnum::Active->value,
        ]);
    }
}
