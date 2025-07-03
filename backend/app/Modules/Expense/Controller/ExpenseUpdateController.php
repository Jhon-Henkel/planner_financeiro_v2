<?php

namespace App\Modules\Expense\Controller;

use App\Infra\Controller\Update\BaseUpdateController;
use App\Infra\UseCase\Update\IUpdateUseCase;
use App\Modules\Expense\UseCase\ExpenseUpdateUseCase;

class ExpenseUpdateController extends BaseUpdateController
{
    public function __construct(protected ExpenseUpdateUseCase $useCase)
    {
    }

    protected function getUseCase(): IUpdateUseCase
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'description' => 'required|string|max:255|min:2',
            'variable' => 'required|boolean',
            'dateStart' => 'required|date_format:Y-m-d',
            'installments' => 'required|int|min:1',
            'amount' => 'required|decimal:0,2|min:0.01',
            'observations' => 'nullable|string|min:1|max:255',
            'installmentId' => 'nullable|int',
            'onlyThisInstallment' => 'required|boolean',
        ];
    }
}
