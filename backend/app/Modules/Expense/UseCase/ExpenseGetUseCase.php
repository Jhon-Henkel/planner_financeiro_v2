<?php

namespace App\Modules\Expense\UseCase;

use App\Infra\UseCase\Read\IGetUseCase;
use App\Models\Expense\Expense;

class ExpenseGetUseCase implements IGetUseCase
{
    public function execute(int $id): array
    {
        return Expense::findOrFail($id)->toArray();
    }
}
