<?php

namespace App\Modules\Expense\Controller;

use App\Infra\Controller\Read\BaseListController;
use App\Infra\UseCase\Read\IListUseCase;
use App\Modules\Expense\UseCase\ExpenseListUseCase;

class ExpenseListController extends BaseListController
{
    public function __construct(protected ExpenseListUseCase $useCase)
    {
    }

    protected function getUseCase(): IListUseCase
    {
        return $this->useCase;
    }
}
