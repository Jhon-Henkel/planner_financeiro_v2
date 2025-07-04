<?php

namespace Feature\Modules\Wallet\Controller;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Response\Enum\HttpStatusCodeEnum;
use App\Infra\Route\Enum\RouteNameEnum;
use App\Models\Movement\Movement;
use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\FeatureTestCase;

class WalletUpdateControllerFeatureTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $wallet = Wallet::where('name', 'PHP Unit Test Wallet')->first();
        if ($wallet) {
            Movement::where('wallet_id', $wallet->id)->delete();
            $wallet->delete();
        }
        $wallet = Wallet::where('name', 'PHP Unit Test Wallet Updated')->first();
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
        $wallet = Wallet::where('name', 'PHP Unit Test Wallet Updated')->first();
        if ($wallet) {
            Movement::where('wallet_id', $wallet->id)->delete();
            $wallet->delete();
        }
        parent::tearDown();
    }

    #[TestDox("Testando com alteração de saldo do tipo recebido")]
    public function testRouteTestOne()
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

        $walletId = $response->json('data.id');

        $response = $this->putJson(route(RouteNameEnum::ApiWalletUpdate, ['id' => $walletId]), [
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

        $this->assertDatabaseHas(Movement::class, [
            'description' =>  'Atualização de saldo',
            'amount' => 100,
            'type' => MovementTypeEnum::Received->value,
            'wallet_id' => $walletId,
        ]);
    }

    #[TestDox("Testando com alteração de saldo do tipo gasto")]
    public function testRouteTestTwo()
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

        $walletId = $response->json('data.id');

        $response = $this->putJson(route(RouteNameEnum::ApiWalletUpdate, ['id' => $walletId]), [
            'name' => 'PHP Unit Test Wallet Updated',
            'amount' => 50,
            'hidden' => true,
            'status' => StatusActiveInactiveEnum::Inactive->value,
        ], $this->makeHeaders());

        $response->assertStatus(HttpStatusCodeEnum::HttpOk->value);

        $this->assertDatabaseHas(Wallet::class, [
            'name' =>  'PHP Unit Test Wallet Updated',
            'amount' => 50,
            'hidden' => true,
            'status' => StatusActiveInactiveEnum::Inactive->value,
        ]);

        $this->assertDatabaseHas(Movement::class, [
            'description' =>  'Atualização de saldo',
            'amount' => 50,
            'type' => MovementTypeEnum::Spent->value,
            'wallet_id' => $walletId,
        ]);
    }
}
