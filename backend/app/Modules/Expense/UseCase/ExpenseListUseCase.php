<?php

namespace App\Modules\Expense\UseCase;

use App\Infra\UseCase\Read\IListUseCase;
use App\Models\Expense\Expense;
use App\Modules\Expense\Enum\ExpenseTypeEnum;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ExpenseListUseCase implements IListUseCase
{
    public function execute(int $perPage, int $page, string $search, string $orderBy, string $orderByDirection, array|null $queryParams = null): array
    {
        $data = Expense::query()->select(
            'expenses.*',
            'expenses_installment.*',
            DB::raw(ExpenseTypeEnum::rawQueryCase('expenses.type', true, 'expenses_installment.installment_number', 'expenses.total_installments')),
        );

        $data->leftJoin('expenses_installment', 'expenses_installment.expense_id', '=', 'expenses.id');

        if (!empty($search)) {
            $data->where(function ($query) use ($search) {
                $query->whereLike(DB::raw(ExpenseTypeEnum::rawQueryCase('expenses.type', false, 'expenses_installment.installment_number', 'expenses.total_installments')), "%$search%")
                    ->orWhereLike('expenses.description', "%$search%");
            });
        }

        if (isset($queryParams['date_start'])) {
            $data->where('expenses_installment.due_date', '>=', $queryParams['date_start']);
        } else {
            $data->where('expenses_installment.due_date', '>=', Carbon::now()->startOfMonth());
        }

        if (isset($queryParams['date_end'])) {
            $data->where('expenses_installment.due_date', '<=', $queryParams['date_end']);
        } else {
            $data->where('expenses_installment.due_date', '<=', Carbon::now()->endOfMonth());
        }

        $data->where('expenses_installment.paid', '=', false);

        if ($orderBy === 'created_at') {
            $orderBy = 'expenses.created_at';
        } else if ($orderBy === 'due_date') {
            $orderBy = 'expenses_installment.due_date';
        } else if ($orderBy === 'amount') {
            $orderBy = 'expenses_installment.amount';
        } else if ($orderBy === 'id') {
            $orderBy = 'expenses.id';
        }

        return $data->orderBy($orderBy, $orderByDirection)->paginate($perPage, ['*'], 'page', $page)->toArray();
    }
}
