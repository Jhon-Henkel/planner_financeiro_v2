<?php

namespace App\Modules\Movement\UseCase;

use App\Infra\UseCase\Update\IUpdateUseCase;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Movement\Exceptions\MovementTypeDontIdentifiedException;
use App\Modules\Wallet\UseCase\Actions\WalletUpdateAmountUseCase;

class MovementUpdateUseCase implements IUpdateUseCase
{
    public function __construct(protected WalletUpdateAmountUseCase $walletUpdateAmountUseCase)
    {
    }

    public function execute(array $data, int $id): array
    {
        $movement = Movement::findOrFail($id);
        $movement->wallet->dontCreateMovementOnUpdate();

        if ($movement->amount != $data['amount']) {
            $type = $this->getTypeForMovementUpdate($movement, $data);

            if (MovementTypeEnum::isReceived($type->value)) {
                $newAmount = round($data['amount'] - $movement->amount, 2);
            } else {
                $newAmount = round($movement->amount - $data['amount'], 2);
            }

            $this->walletUpdateAmountUseCase->execute($movement->wallet, abs($newAmount), $type);
        }

        $movement->update([
            'description' => $data['description'],
            'amount' => $data['amount']
        ]);

        return $movement->refresh()->toArray();
    }

    protected function getTypeForMovementUpdate(Movement $movement, array $data): MovementTypeEnum
    {
        if (MovementTypeEnum::isReceived($movement->type) && $movement->amount > $data['amount']) {
            return MovementTypeEnum::Spent;
        } elseif (MovementTypeEnum::isReceived($movement->type) && $movement->amount < $data['amount']) {
            return MovementTypeEnum::Received;
        } elseif (MovementTypeEnum::isSpent($movement->type) && $movement->amount > $data['amount']) {
            return MovementTypeEnum::Received;
        } elseif (MovementTypeEnum::isSpent($movement->type) && $movement->amount < $data['amount']) {
            return MovementTypeEnum::Spent;
        }
        throw new MovementTypeDontIdentifiedException();
    }
}
