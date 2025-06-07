<?php

namespace Feature\Modules\Wallet\Controller;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Response\Enum\HttpStatusCodeEnum;
use App\Infra\Route\Enum\RouteNameEnum;
use App\Models\Wallet\Wallet;
use Tests\FeatureTestCase;

class WalletUpdateControllerFeatureTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Wallet::where('name', 'PHP Unit Test Wallet')->delete();
        Wallet::where('name', 'PHP Unit Test Wallet Updated')->delete();
    }

    protected function tearDown(): void
    {
        Wallet::where('name', 'PHP Unit Test Wallet')->delete();
        Wallet::where('name', 'PHP Unit Test Wallet Updated')->delete();
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

        $response = $this->putJson(route(RouteNameEnum::ApiWalletUpdate, ['id' => $response->json('data.id')]), [
            'name' => 'PHP Unit Test Wallet Updated',
            'amount' => 200,
            'hidden' => true,
            'status' => StatusActiveInactiveEnum::Inactive->value,
        ], $this->makeHeaders());

        $response->assertStatus(HttpStatusCodeEnum::HttpOk->value);

        $this->assertDatabaseHas(Wallet::class, [
            'name' =>  'PHP Unit Test Wallet Updated',
            'amount' => 200,
            'hidden' => true,
            'status' => StatusActiveInactiveEnum::Inactive->value,
        ]);
    }
}
