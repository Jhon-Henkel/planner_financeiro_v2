<?php

namespace Feature\Modules\Movement\Controller;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Response\Enum\HttpStatusCodeEnum;
use App\Infra\Route\Enum\RouteNameEnum;
use App\Models\Movement\Movement;
use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Tests\FeatureTestCase;

class MovementListControllerFeatureTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $wallet = Wallet::where('name', 'PHP Unit Test Wallet')->first();
        if ($wallet) {
            Movement::where('wallet_id', $wallet->id)->delete();
            $wallet->delete();
        }
    }

    protected function tearDown(): void
    {
        $wallet = Wallet::where('name', 'PHP Unit Test Wallet')->first();
        if ($wallet) {
            Movement::where('wallet_id', $wallet->id)->delete();
            $wallet->delete();
        }
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
            'name' => 'PHP Unit Test Wallet',
            'amount' => 100,
            'hidden' => false,
            'status' => StatusActiveInactiveEnum::Active->value,
        ]);

        $walletId = $response->json('data.id');

        $response = $this->postJson(route(RouteNameEnum::ApiMovementCreate), [
            'description' => 'PHP Unit Test Movement',
            'type' => MovementTypeEnum::Received->value,
            'wallet_id' => $walletId,
            'amount' => 200,
        ], $this->makeHeaders());

        $response->assertStatus(HttpStatusCodeEnum::HttpCreated->value);

        $this->assertDatabaseHas(Movement::class, [
            'description' => 'PHP Unit Test Movement',
            'amount' => 200,
            'type' => MovementTypeEnum::Received->value,
            'wallet_id' => $walletId,
        ]);

        $this->assertDatabaseHas(Wallet::class, [
            'id' => $walletId,
            'name' => 'PHP Unit Test Wallet',
            'amount' => 300,
            'hidden' => false,
            'status' => StatusActiveInactiveEnum::Active->value,
        ]);

        $response = $this->getJson(route(RouteNameEnum::ApiMovementList), $this->makeHeaders());

        $response->assertStatus(HttpStatusCodeEnum::HttpOk->value);

        $response->assertJsonStructure([
            'status',
            'data' => [
                '*' => [
                    'id',
                    'wallet_id',
                    'description',
                    'type',
                    'amount',
                    'wallet_name',
                    'type_label',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }
}
