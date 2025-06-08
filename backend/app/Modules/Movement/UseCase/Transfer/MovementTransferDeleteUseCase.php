<?php

namespace App\Modules\Movement\UseCase\Transfer;

use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Wallet\UseCase\Actions\WalletUpdateAmountUseCase;

class MovementTransferDeleteUseCase implements IDeleteUseCase
{
    public function __construct(protected WalletUpdateAmountUseCase $walletUpdateAmountUseCase)
    {
    }

    public function execute(int $id): void
    {
        $movement = Movement::find($id);

        if (is_null($movement) || $movement->type != MovementTypeEnum::Transfer->value) {
            return;
        }

        if (str_contains($movement->description, 'Saída')) {
            $this->walletUpdateAmountUseCase->execute($movement->wallet, $movement->amount, MovementTypeEnum::Received);
        } elseif (str_contains($movement->description, 'Entrada')) {
            $this->walletUpdateAmountUseCase->execute($movement->wallet, $movement->amount, MovementTypeEnum::Spent);
        }

        $movement->delete();
    }
}
