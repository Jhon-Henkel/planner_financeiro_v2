<?php

namespace Feature\Modules\Movement\Controller\Transfer;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Response\Enum\HttpStatusCodeEnum;
use App\Infra\Route\Enum\RouteNameEnum;
use App\Models\Movement\Movement;
use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Tests\FeatureTestCase;

class MovementTransferDeleteControllerFeatureTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $wallet = Wallet::where('name', 'PHP Unit Test Wallet')->first();
        if ($wallet) {
            Movement::where('wallet_id', $wallet->id)->delete();
            $wallet->delete();
        }
        $wallet = Wallet::where('name', 'PHP Unit Test Wallet 2')->first();
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
        $wallet = Wallet::where('name', 'PHP Unit Test Wallet 2')->first();
        if ($wallet) {
            Movement::where('wallet_id', $wallet->id)->delete();
            $wallet->delete();
        }
        parent::tearDown();
    }

    public function testRoute()
    {
        $walletOne = Wallet::create([
            'amount' => 100,
            'name' =>  'PHP Unit Test Wallet',
            'hidden' =>  true,
            'status' => StatusActiveInactiveEnum::Active->value
        ]);

        $walletTwo = Wallet::create([
            'amount' => 50,
            'name' =>  'PHP Unit Test Wallet 2',
            'hidden' =>  true,
            'status' => StatusActiveInactiveEnum::Active->value
        ]);

        $response = $this->postJson(route(RouteNameEnum::ApiMovementTransferCreate), [
            'from_id' => $walletOne->id,
            'to_id' => $walletTwo->id,
            'amount' => 10,
        ], $this->makeHeaders());

        $response->assertStatus(HttpStatusCodeEnum::HttpCreated->value);

        $this->assertDatabaseHas(Movement::class, [
            'description' =>  'Saída transferência',
            'amount' => 10,
            'type' => MovementTypeEnum::Transfer->value,
            'wallet_id' => $walletOne->id,
        ]);

        $this->assertDatabaseHas(Movement::class, [
            'description' =>  'Entrada transferência',
            'amount' => 10,
            'type' => MovementTypeEnum::Transfer->value,
            'wallet_id' => $walletTwo->id,
        ]);

        $this->assertEquals(90, $walletOne->fresh()->amount);
        $this->assertEquals(60, $walletTwo->fresh()->amount);

        $movementOne = Movement::where('description', 'Saída transferência')->firstOrFail();
        $movementTwo = Movement::where('description', 'Entrada transferência')->firstOrFail();

        $response = $this->deleteJson(route(RouteNameEnum::ApiMovementTransferDelete, ['id' => $movementOne->id]), [], $this->makeHeaders());
        $response->assertStatus(HttpStatusCodeEnum::HttpNoContent->value);

        $this->assertDatabaseMissing(Movement::class, [
            'id' => $movementOne->id,
        ]);

        $response = $this->deleteJson(route(RouteNameEnum::ApiMovementTransferDelete, ['id' => $movementTwo->id]), [], $this->makeHeaders());
        $response->assertStatus(HttpStatusCodeEnum::HttpNoContent->value);

        $this->assertDatabaseMissing(Movement::class, [
            'id' => $movementTwo->id,
        ]);

        $this->assertEquals(100, $walletOne->fresh()->amount);
        $this->assertEquals(50, $walletTwo->fresh()->amount);
    }
}
