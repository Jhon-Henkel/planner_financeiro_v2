<?php

namespace Feature\Modules\Wallet\Controller;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Response\Enum\HttpStatusCodeEnum;
use App\Infra\Route\Enum\RouteNameEnum;
use App\Models\Wallet\Wallet;
use Tests\FeatureTestCase;

class WalletGetControllerFeatureTest extends FeatureTestCase
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

        $response = $this->getJson(route(RouteNameEnum::ApiWalletGet, ['id' => $response->json('data.id')]), $this->makeHeaders());

        $response->assertStatus(HttpStatusCodeEnum::HttpOk->value);

        $response->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'name',
                'amount',
                'hidden',
                'status',
                'created_at',
                'updated_at',
            ],
        ]);
    }
}
