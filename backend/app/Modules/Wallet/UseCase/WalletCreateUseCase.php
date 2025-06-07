<?php

namespace App\Modules\Wallet\UseCase;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\UseCase\Create\ICreateUseCase;
use App\Models\Wallet\Wallet;

class WalletCreateUseCase implements ICreateUseCase
{
    public function execute(array $data): array
    {
        return Wallet::create([
            'name' => $data['name'],
            'amount' => $data['amount'],
            'hidden' => $data['hidden'],
            'status' => StatusActiveInactiveEnum::Active->value,
        ])->toArray();
    }
}
