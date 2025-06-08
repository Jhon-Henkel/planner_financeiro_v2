<?php

namespace App\Modules\Movement\UseCase\Transfer;

use App\Infra\UseCase\Create\ICreateUseCase;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Wallet\UseCase\Actions\WalletUpdateAmountUseCase;

class MovementTransferCreateUseCase implements ICreateUseCase
{
    public function __construct(protected WalletUpdateAmountUseCase $walletUpdateAmountUseCase)
    {
    }

    public function execute(array $data): array
    {
        $spent = Movement::create([
            'amount' =>  $data['amount'],
            'description' => 'Saída transferência',
            'type' => MovementTypeEnum::Transfer->value,
            'wallet_id' => $data['from_id'],
        ]);
        $spent->wallet->dontCreateMovementOnUpdate();

        $this->walletUpdateAmountUseCase->execute($spent->wallet, $spent->amount, MovementTypeEnum::Spent);

        $received = Movement::create([
            'amount' =>  $data['amount'],
            'description' => 'Entrada transferência',
            'type' => MovementTypeEnum::Transfer->value,
            'wallet_id' => $data['to_id'],
        ]);
        $received->wallet->dontCreateMovementOnUpdate();

        $this->walletUpdateAmountUseCase->execute($received->wallet, $received->amount, MovementTypeEnum::Received);

        return ['result' => true];
    }
}
