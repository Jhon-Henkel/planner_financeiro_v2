<?php

namespace Tests\Feature\Modules\Expense\Controller;

use App\Infra\Route\Enum\RouteNameEnum;
use App\Models\Expense\Expense;
use App\Models\Expense\ExpenseInstallment;
use App\Modules\Expense\Enum\ExpenseRecurrenceIntervalEnum;
use App\Modules\Expense\Enum\ExpenseTypeEnum;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\FeatureTestCase;

class ExpenseCreateControllerFeatureTest extends FeatureTestCase
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

    #[TestDox("Testando criando uma despesa do tipo installment")]
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

        $expenseId = $response->json('data.id');

        $this->assertDatabaseHas(Expense::class, [
            'id' => $expenseId,
            'description' => 'PHP Unit Test Expense',
            'type' => ExpenseTypeEnum::Installment->value,
            'variable' => false,
            'date_start' => '2023-10-10',
            'amount' => 1000.00,
            'total_installments' => 10,
            'recurrence_interval' => ExpenseRecurrenceIntervalEnum::Monthly->value,
            'observations' => null,
            'date_end' => '2024-07-10',
        ]);

        $this->assertDatabaseCount(ExpenseInstallment::class, 10);

        // Parcela 1 de 10
        $this->assertDatabaseHas(ExpenseInstallment::class, [
            'expense_id' => $expenseId,
            'installment_number' => 1,
            'amount' => 1000.00,
            'due_date' => '2023-10-10',
            'paid' => false,
            'paid_at' => null,
            'bank_slip' => null
        ]);

        // Parcela 2 de 10
        $this->assertDatabaseHas(ExpenseInstallment::class, [
            'expense_id' => $expenseId,
            'installment_number' => 2,
            'amount' => 1000.00,
            'due_date' => '2023-11-10',
            'paid' => false,
            'paid_at' => null,
            'bank_slip' => null
        ]);

        // Parcela 3 de 10
        $this->assertDatabaseHas(ExpenseInstallment::class, [
            'expense_id' => $expenseId,
            'installment_number' => 3,
            'amount' => 1000.00,
            'due_date' => '2023-12-10',
            'paid' => false,
            'paid_at' => null,
            'bank_slip' => null
        ]);

        // Parcela 4 de 10
        $this->assertDatabaseHas(ExpenseInstallment::class, [
            'expense_id' => $expenseId,
            'installment_number' => 4,
            'amount' => 1000.00,
            'due_date' => '2024-01-10',
            'paid' => false,
            'paid_at' => null,
            'bank_slip' => null
        ]);

        // Parcela 5 de 10
        $this->assertDatabaseHas(ExpenseInstallment::class, [
            'expense_id' => $expenseId,
            'installment_number' => 5,
            'amount' => 1000.00,
            'due_date' => '2024-02-10',
            'paid' => false,
            'paid_at' => null,
            'bank_slip' => null
        ]);

        // Parcela 6 de 10
        $this->assertDatabaseHas(ExpenseInstallment::class, [
            'expense_id' => $expenseId,
            'installment_number' => 6,
            'amount' => 1000.00,
            'due_date' => '2024-03-10',
            'paid' => false,
            'paid_at' => null,
            'bank_slip' => null
        ]);

        // Parcela 7 de 10
        $this->assertDatabaseHas(ExpenseInstallment::class, [
            'expense_id' => $expenseId,
            'installment_number' => 7,
            'amount' => 1000.00,
            'due_date' => '2024-04-10',
            'paid' => false,
            'paid_at' => null,
            'bank_slip' => null
        ]);

        // Parcela 8 de 10
        $this->assertDatabaseHas(ExpenseInstallment::class, [
            'expense_id' => $expenseId,
            'installment_number' => 8,
            'amount' => 1000.00,
            'due_date' => '2024-05-10',
            'paid' => false,
            'paid_at' => null,
            'bank_slip' => null
        ]);

        // Parcela 9 de 10
        $this->assertDatabaseHas(ExpenseInstallment::class, [
            'expense_id' => $expenseId,
            'installment_number' => 9,
            'amount' => 1000.00,
            'due_date' => '2024-06-10',
            'paid' => false,
            'paid_at' => null,
            'bank_slip' => null
        ]);

        // Parcela 10 de 10
        $this->assertDatabaseHas(ExpenseInstallment::class, [
            'expense_id' => $expenseId,
            'installment_number' => 10,
            'amount' => 1000.00,
            'due_date' => '2024-07-10',
            'paid' => false,
            'paid_at' => null,
            'bank_slip' => null
        ]);
    }

    #[TestDox("Testando criando uma despesa do tipo one time")]
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

        $expenseId = $response->json('data.id');

        $this->assertDatabaseHas(Expense::class, [
            'id' => $expenseId,
            'description' => 'PHP Unit Test Expense',
            'type' => ExpenseTypeEnum::OneTime->value,
            'variable' => false,
            'date_start' => '2023-10-10',
            'amount' => 1000.00,
            'total_installments' => 1,
            'recurrence_interval' => ExpenseRecurrenceIntervalEnum::Monthly->value,
            'observations' => null,
            'date_end' => '2023-10-10',
        ]);

        $this->assertDatabaseCount(ExpenseInstallment::class, 1);

        $this->assertDatabaseHas(ExpenseInstallment::class, [
            'expense_id' => $expenseId,
            'installment_number' => 1,
            'amount' => 1000.00,
            'due_date' => '2023-10-10',
            'paid' => false,
            'paid_at' => null,
            'bank_slip' => null
        ]);
    }

    #[TestDox("Testando criando uma despesa do tipo fixed")]
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

        $expenseId = $response->json('data.id');

        $this->assertDatabaseHas(Expense::class, [
            'id' => $expenseId,
            'description' => 'PHP Unit Test Expense',
            'type' => ExpenseTypeEnum::Fixed->value,
            'variable' => false,
            'date_start' => '2023-10-10',
            'amount' => 1000.00,
            'total_installments' => null,
            'recurrence_interval' => ExpenseRecurrenceIntervalEnum::Monthly->value,
            'observations' => null,
            'date_end' => '2023-10-10',
        ]);

        $this->assertDatabaseCount(ExpenseInstallment::class, 0);
    }
}
