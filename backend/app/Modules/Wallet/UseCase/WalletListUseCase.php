<?php

namespace App\Modules\Wallet\UseCase;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\UseCase\Read\IListUseCase;
use App\Models\Wallet\Wallet;
use Illuminate\Support\Facades\DB;

class WalletListUseCase implements IListUseCase
{
    public function execute(int $perPage, int $page, string $search, string $orderBy, string $orderByDirection, array|null $queryParams = null): array
    {
        $data = Wallet::query()->select(
            'wallets.*',
            DB::raw(StatusActiveInactiveEnum::rawQueryCase('wallets.status', true)),
        );

        if (isset($queryParams['status'])) {
            $data->where('wallets.status', $queryParams['status']);
        }

        if (!empty($search)) {
            $data->where(function ($query) use ($search) {
                $query->where(DB::raw(StatusActiveInactiveEnum::rawQueryCase('wallets.status', false)), 'ilike', "%$search%")
                    ->orWhere('wallets.name', 'ilike', "%$search%")
                    ->orWhere('wallets.amount', 'like', "%$search%");
            });
        }

        return $data->orderBy($orderBy, $orderByDirection)->paginate($perPage, ['*'], 'page', $page)->toArray();
    }
}
