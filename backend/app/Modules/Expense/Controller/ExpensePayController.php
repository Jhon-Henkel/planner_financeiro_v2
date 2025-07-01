<?php

namespace App\Modules\Expense\Controller;

use App\Infra\Controller\Create\BaseCreateController;
use App\Infra\UseCase\Create\ICreateUseCase;
use App\Modules\Expense\UseCase\ExpensePayUseCase;

class ExpensePayController extends BaseCreateController
{
    public function __construct(protected ExpensePayUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCase
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'amount' => 'required|decimal:0,2|min:0.01',
            'walletId' => 'required|int|exists:App\Models\Wallet\Wallet,id',
            'installmentId' => 'nullable|int|exists:App\Models\Expense\ExpenseInstallment,id',
            'expenseId' => 'required|int|exists:App\Models\Expense\Expense,id',
        ];
    }
}
