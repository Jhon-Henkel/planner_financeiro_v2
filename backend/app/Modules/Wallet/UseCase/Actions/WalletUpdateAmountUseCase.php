<?php

namespace App\Modules\Wallet\UseCase\Actions;

use App\Models\Movement\Movement;
use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;

class WalletUpdateAmountUseCase
{
    public function execute(Wallet $wallet, float $amount, MovementTypeEnum $type): void
    {
        if ($wallet->createMovementOnUpdate) {
            $this->insertMovement($wallet, $amount, $type);
        }

        if ($type === MovementTypeEnum::Received) {
            $wallet->amount += abs($amount);
        } elseif ($type === MovementTypeEnum::Spent) {
            $wallet->amount -= abs($amount);
        }

        $wallet->update();
    }

    protected function insertMovement(Wallet $wallet, float $amount, MovementTypeEnum $type): void
    {
        Movement::create([
            'type' => $type->value,
            'wallet_id' =>  $wallet->id,
            'amount' => abs($amount),
            'description' => 'Atualização de saldo'
        ]);
    }
}
