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
                $query->where(DB::raw(MovementTypeEnum::rawQueryCase('movements.type', false)), 'ilike', "%$search%")
                    ->orWhere('wallets.name', 'ilike', "%$search%")
                    ->orWhere('movements.amount', 'like', "%$search%")
                    ->orWhere('movements.description', 'like', "%$search%");
            });
        }

        return $data->orderBy($orderBy, $orderByDirection)->paginate($perPage, ['*'], 'page', $page)->toArray();
    }
}
