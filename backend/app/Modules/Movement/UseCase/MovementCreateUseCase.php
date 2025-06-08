<?php

namespace App\Modules\Movement\UseCase;

use App\Infra\UseCase\Create\ICreateUseCase;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Wallet\UseCase\Actions\WalletUpdateAmountUseCase;

class MovementCreateUseCase implements ICreateUseCase
{
    public function execute(array $data): array
    {
        $item = Movement::create($data);
        $item->wallet->dontCreateMovementOnUpdate();

        new WalletUpdateAmountUseCase()->execute($item->wallet, $item->amount, MovementTypeEnum::getEnum($item->type));

        return $item->toArray();
    }
}
