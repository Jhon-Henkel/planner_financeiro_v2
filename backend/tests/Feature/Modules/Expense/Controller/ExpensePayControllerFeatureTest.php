<?php

namespace Tests\Feature\Modules\Expense\Controller;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Route\Enum\RouteNameEnum;
use App\Models\Expense\Expense;
use App\Models\Expense\ExpenseInstallment;
use App\Models\Movement\Movement;
use App\Models\Wallet\Wallet;
use App\Modules\Expense\Enum\ExpenseTypeEnum;
use App\Modules\Movement\Enum\MovementTypeEnum;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\FeatureTestCase;

class ExpensePayControllerFeatureTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $expense = Expense::where('description', 'PHP Unit Test Expense')->first();
        if ($expense) {
            $expense->installments()->delete();
            $expense->delete();
        }
        $wallet = Wallet::where('name', 'PHP Unit Test Wallet')->first();
        if ($wallet) {
            Movement::where('wallet_id', $wallet->id);
        }
        $wallet?->delete();
    }

    protected function tearDown(): void
    {
        $expense = Expense::where('description', 'PHP Unit Test Expense')->first();
        if ($expense) {
            $expense->installments()->delete();
            $expense->delete();
        }
        $wallet = Wallet::where('name', 'PHP Unit Test Wallet')->first();
        if ($wallet) {
            Movement::where('wallet_id', $wallet->id);
        }
        $wallet?->delete();
        parent::tearDown();
    }

    #[TestDox("Testando o pagamento de uma despesa do tipo installment")]
    public function testRouteTestOne()
    {
        $response = $this->postJson(
            route(RouteNameEnum::ApiExpenseCreate),
            [
                'description' => 'PHP Unit Test Expense',
                'type' => ExpenseTypeEnum::Installment->value,
                'variable' => false,
                'dateStart' => '2023-10-10',
                'installments' => 10,
                'amount' => 1000,
                'observations' => null,
            ],
            $this->makeHeaders()
        )->assertCreated();

        $wallet = Wallet::create([
            'amount' => 2000,
            'hidden' => false,
            'name' => 'PHP Unit Test Wallet',
            'status' => StatusActiveInactiveEnum::Active->value,
        ]);

        $installment = ExpenseInstallment::where('expense_id', $response->json('data.id'))
            ->where('installment_number', 1)
            ->first();

        $this->postJson(
            route(RouteNameEnum::ApiExpensePay),
            [
                'amount' => 1000,
                'walletId' => $wallet->id,
                'installmentId' => $installment->id,
            ],
            $this->makeHeaders()
        )->assertCreated();

        $installment->refresh();
        $wallet->refresh();

        $this->assertTrue($installment->paid);
        $this->assertNotNull($installment->paid_at);
        $this->assertEquals(1000, $installment->amount);

        $this->assertEquals(1000, $wallet->amount);

        $this->assertDatabaseHas(Movement::class, [
            'description' => 'PHP Unit Test Expense',
            'amount' => 1000,
            'type' => MovementTypeEnum::Spent->value,
            'wallet_id' => $wallet->id,
        ]);
    }

    #[TestDox("Testando o pagamento de uma despesa do tipo one time")]
    public function testRouteTestTwo()
    {
        $response = $this->postJson(
            route(RouteNameEnum::ApiExpenseCreate),
            [
                'description' => 'PHP Unit Test Expense',
                'type' => ExpenseTypeEnum::OneTime->value,
                'variable' => false,
                'dateStart' => '2023-10-10',
                'installments' => 1,
                'amount' => 1000,
                'observations' => null,
            ],
            $this->makeHeaders()
        )->assertCreated();

    }

    #[TestDox("Testando o pagamento de uma despesa do tipo fixed")]
    public function testRouteTestThree()
    {
        $response = $this->postJson(
            route(RouteNameEnum::ApiExpenseCreate),
            [
                'description' => 'PHP Unit Test Expense',
                'type' => ExpenseTypeEnum::Fixed->value,
                'variable' => false,
                'dateStart' => '2023-10-10',
                'installments' => 1,
                'amount' => 1000,
                'observations' => null,
            ],
            $this->makeHeaders()
        )->assertCreated();
    }
}
