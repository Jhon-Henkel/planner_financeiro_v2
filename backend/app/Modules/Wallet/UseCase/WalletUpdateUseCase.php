<?php

namespace App\Modules\Wallet\UseCase;

use App\Infra\UseCase\Update\IUpdateUseCase;
use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Wallet\UseCase\Actions\WalletUpdateAmountUseCase;

class WalletUpdateUseCase implements IUpdateUseCase
{
    public function execute(array $data, int $id): array
    {
        $item = Wallet::findOrFail($id);

        if ($item->amount != $data['amount']) {
            $difference = round($data['amount'] - $item->amount, 2);
            $type = $difference > 0 ? MovementTypeEnum::Received : MovementTypeEnum::Spent;
            new WalletUpdateAmountUseCase()->execute($item, $difference, $type);
        }

        $item->update([
            'name' => $data['name'],
            'hidden' => $data['hidden'],
            'status' => $data['status'],
        ]);

        return $item->refresh()->toArray();
    }
}
