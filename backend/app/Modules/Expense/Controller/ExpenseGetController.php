<?php

namespace App\Modules\Expense\Controller;

use App\Infra\Controller\Read\BaseGetController;
use App\Infra\UseCase\Read\IGetUseCase;
use App\Modules\Expense\UseCase\ExpenseGetUseCase;

class ExpenseGetController extends BaseGetController
{
    public function __construct(protected ExpenseGetUseCase $useCase)
    {
    }

    protected function getUseCase(): IGetUseCase
    {
        return $this->useCase;
    }
}
