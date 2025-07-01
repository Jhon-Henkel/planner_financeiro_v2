<?php

namespace App\Modules\Expense\UseCase;

use App\Infra\UseCase\Create\ICreateUseCase;
use App\Models\Expense\Expense;
use App\Models\Expense\ExpenseInstallment;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Movement\UseCase\MovementCreateUseCase;

class ExpensePayUseCase implements ICreateUseCase
{
    public function __construct(protected MovementCreateUseCase $movementCreateUseCase)
    {
    }

    public function execute(array $data): array
    {
        $expense = Expense::findOrFail($data['expenseId']);

        if (! is_null($data['installmentId'])) {
            $installment = ExpenseInstallment::findOrFail($data['installmentId']);
            $installment->update([
                'paid' => true,
                'paid_at' => now(),
                'amount' => $data['amount'],
            ]);
        }

        $this->movementCreateUseCase->execute([
            'description' => $expense->description,
            'type' => MovementTypeEnum::Spent->value,
            'wallet_id' => $data['walletId'],
            'amount' => $data['amount'],
        ]);

        return $expense->refresh()->toArray();
    }
}
