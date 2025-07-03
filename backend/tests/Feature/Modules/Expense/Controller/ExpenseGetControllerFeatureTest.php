<?php

namespace Tests\Feature\Modules\Expense\Controller;

use App\Infra\Route\Enum\RouteNameEnum;
use App\Models\Expense\Expense;
use App\Modules\Expense\Enum\ExpenseTypeEnum;
use Tests\FeatureTestCase;

class ExpenseGetControllerFeatureTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $expense = Expense::where('description', 'PHP Unit Test Expense')->first();
        if ($expense) {
            $expense->installments()->delete();
            $expense->delete();
        }
    }

    protected function tearDown(): void
    {
        $expense = Expense::where('description', 'PHP Unit Test Expense')->first();
        if ($expense) {
            $expense->installments()->delete();
            $expense->delete();
        }
        parent::tearDown();
    }

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

        $this->getJson(route(RouteNameEnum::ApiExpenseGet, [$response->json('data.id')]), $this->makeHeaders())->assertOk();
    }
}
