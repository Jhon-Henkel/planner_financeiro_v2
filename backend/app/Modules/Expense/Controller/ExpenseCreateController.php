<?php

namespace App\Modules\Expense\Controller;

use App\Infra\Controller\Create\BaseCreateController;
use App\Infra\UseCase\Create\ICreateUseCase;
use App\Modules\Expense\Enum\ExpenseTypeEnum;
use App\Modules\Expense\UseCase\ExpenseCreateUseCase;

class ExpenseCreateController extends BaseCreateController
{
    public function __construct(protected ExpenseCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCase
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'description' => 'required|string|max:255|min:2',
            'type' => 'required|int|in:' . ExpenseTypeEnum::getForValidation(),
            'variable' => 'required|boolean',
            'dateStart' => 'required|date_format:Y-m-d',
            'installments' => 'required|int|min:1',
            'amount' => 'required|decimal:0,2|min:0.01',
            'bankSlip' => 'nullable|string|min:1|max:255',
            'observations' => 'nullable|string|min:1|max:255',
        ];
    }
}
