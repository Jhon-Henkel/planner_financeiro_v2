<?php

namespace App\Modules\Movement\UseCase;

use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Wallet\UseCase\Actions\WalletUpdateAmountUseCase;

class MovementDeleteUseCase implements IDeleteUseCase
{
    public function __construct(protected WalletUpdateAmountUseCase $walletUpdateAmountUseCase)
    {
    }

    public function execute(int $id): void
    {
        $movement = Movement::find($id);

        if (! $movement) {
            return;
        }

        $movement->wallet->dontCreateMovementOnUpdate();

        $type = MovementTypeEnum::isReceived($movement->type) ? MovementTypeEnum::Spent : MovementTypeEnum::Received;
        $this->walletUpdateAmountUseCase->execute($movement->wallet, $movement->amount, $type);

        $movement->delete();
    }
}
