<?php

namespace App\Modules\Expense\UseCase;

use App\Infra\UseCase\Update\IUpdateUseCase;
use App\Models\Expense\Expense;
use App\Models\Expense\ExpenseInstallment;

class ExpenseUpdateUseCase implements IUpdateUseCase
{
    public function execute(array $data, int $id): array
    {
        /**
         * se total de parcelas for maior que o atual
         *      adicionar parcelas faltantes
         * se total de parcelas for menor que o atual
         *      total de parcelas não pode ser menor que o total de parcelas já pagas
         *      remover parcelas não pagas restantes
         */
        $expense = Expense::findOrFail($id);
        $installment = null;
        if ($expense->isFixedType()) {
            $installment = ExpenseInstallment::findOrFail($data['installmentId']);
        }
    }
}
