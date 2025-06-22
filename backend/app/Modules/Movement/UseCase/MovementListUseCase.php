<?php

namespace App\Modules\Movement\UseCase;

use App\Infra\UseCase\Read\IListUseCase;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Illuminate\Support\Facades\DB;

class MovementListUseCase implements IListUseCase
{
    public function execute(int $perPage, int $page, string $search, string $orderBy, string $orderByDirection, array|null $queryParams = null): array
    {
        $data = Movement::query()->select(
            'movements.*',
            'wallets.name as wallet_name',
            DB::raw(MovementTypeEnum::rawQueryCase('movements.type', true)),
        );

        $data->leftJoin('wallets', 'movements.wallet_id', '=', 'wallets.id');

        if (!empty($search)) {
            $data->where(function ($query) use ($search) {
                $query->whereLike(DB::raw(MovementTypeEnum::rawQueryCase('movements.type', false)), "%$search%")
                    ->orWhereLike('wallets.name', "%$search%")
                    ->orWhereLike('movements.amount', "%$search%")
                    ->orWhereLike('movements.description', "%$search%");
            });
        }

        if (isset($queryParams['date_start'])) {
            $data->where('movements.created_at', '>=', $queryParams['date_start']);
        }

        if (isset($queryParams['date_end'])) {
            $data->where('movements.created_at', '<=', $queryParams['date_end']);
        }

        $data = $data->orderBy($orderBy, $orderByDirection)->paginate($perPage, ['*'], 'page', $page)->toArray();
        $data['meta'] = $this->getDetails($queryParams);
        return $data;
    }

    protected function getDetails(array|null $queryParams = null): array
    {
        $spent = Movement::where('type', MovementTypeEnum::Spent->value);
        if (isset($queryParams['date_start'])) {
            $spent->where('created_at', '>=', $queryParams['date_start']);
        }
        if (isset($queryParams['date_end'])) {
            $spent->where('created_at', '<=', $queryParams['date_end']);
        }
        $spent = $spent->sum('amount');

        $received = Movement::where('type', MovementTypeEnum::Received->value);
        if (isset($queryParams['date_start'])) {
            $received->where('created_at', '>=', $queryParams['date_start']);
        }
        if (isset($queryParams['date_end'])) {
            $received->where('created_at', '<=', $queryParams['date_end']);
        }
        $received = $received->sum('amount');

        $balance = round($received - $spent, 2);

        return [
            'details' => [
                ['label' => 'Recebido', 'value' => $received, 'color' => 'success', 'full' => false],
                ['label' => 'Gasto', 'value' => $spent, 'color' => 'error', 'full' => false],
                ['label' => 'Saldo', 'value' => $balance, 'color' => $balance <= 0 ? 'error' : 'success', 'full' => true],
            ]
        ];
    }
}
