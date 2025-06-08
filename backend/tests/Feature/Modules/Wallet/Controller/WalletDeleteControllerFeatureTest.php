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

class WalletDeleteControllerFeatureTest extends FeatureTestCase
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

    #[TestDox("Testando exclusão de carteira")]
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

        $response = $this->deleteJson(route(RouteNameEnum::ApiWalletDelete, ['id' => $response->json('data.id')]), [], $this->makeHeaders());

        $response->assertStatus(HttpStatusCodeEnum::HttpNoContent->value);

        $this->assertDatabaseMissing(Wallet::class, [
            'name' =>  'PHP Unit Test Wallet',
            'amount' => 100,
            'hidden' => false,
            'status' => StatusActiveInactiveEnum::Active->value,
        ]);
    }

    #[TestDox("Testando exclusão de carteira que não existe")]
    public function testRouteTestTwo()
    {
        $response = $this->deleteJson(route(RouteNameEnum::ApiWalletDelete, ['id' => 9999]), [], $this->makeHeaders());

        $response->assertStatus(HttpStatusCodeEnum::HttpNoContent->value);
    }

    #[TestDox("Testando exclusão de carteira com movimentação associada")]
    public function testRouteTestThree()
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

        $response = $this->postJson(route(RouteNameEnum::ApiMovementCreate), [
            'description' => 'PHP Unit Test Movement',
            'type' => MovementTypeEnum::Spent->value,
            'wallet_id' => $walletId,
            'amount' => 30,
        ], $this->makeHeaders());

        $response = $this->deleteJson(route(RouteNameEnum::ApiWalletDelete, ['id' => $walletId]), [], $this->makeHeaders());

        $response->assertStatus(HttpStatusCodeEnum::HttpBadRequest->value);
        $this->assertEquals('Não é possível excluir uma carteira que possui movimentações associadas.', $response->json('data'));

        $this->assertDatabaseHas(Wallet::class, [
            'name' =>  'PHP Unit Test Wallet',
            'amount' => 70,
            'hidden' => false,
            'status' => StatusActiveInactiveEnum::Active->value,
        ]);

    }
}
