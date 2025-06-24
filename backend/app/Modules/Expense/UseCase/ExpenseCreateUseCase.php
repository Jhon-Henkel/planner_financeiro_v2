<?php

namespace App\Modules\Expense\UseCase;

use App\Infra\UseCase\Create\ICreateUseCase;
use App\Models\Expense\Expense;
use App\Models\Expense\ExpenseInstallment;
use App\Modules\Expense\Enum\ExpenseRecurrenceIntervalEnum;
use Illuminate\Support\Carbon;

class ExpenseCreateUseCase implements ICreateUseCase
{
    public function execute(array $data): array
    {
        $expense = Expense::create([
            'amount' => $data['amount'],
            'type' => $data['type'],
            'date_start' => $data['dateStart'],
            'date_end' => Carbon::parse($data['dateStart'])->addMonths($data['installments'] - 1),
            'recurrence_interval' => ExpenseRecurrenceIntervalEnum::Monthly->value,
            'description' => $data['description'],
            'total_installments' => $data['installments'],
            'variable' => $data['variable'],
            'observations' => $data['observations'],
        ]);
        $this->insertInstallments($expense, $data);
        return $expense->with('installments')->first()->toArray();
    }

    protected function insertInstallments(Expense $expense, array $data): void
    {
        for ($i = 1; $i <= $data['installments']; $i++) {
            ExpenseInstallment::create([
                'amount' => $data['amount'],
                'expense_id' => $expense->id,
                'bank_slip' => $data['bankSlip'],
                'installment_number' => $i,
                'due_date' => Carbon::parse($data['dateStart'])->addMonths($i - 1),
                'paid' => false,
                'paid_at' => null,
            ]);
        }
    }
}
