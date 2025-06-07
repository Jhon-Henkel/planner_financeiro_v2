<?php

namespace App\Modules\Wallet\UseCase;

use App\Infra\UseCase\Update\IUpdateUseCase;
use App\Models\Wallet\Wallet;

class WalletUpdateUseCase implements IUpdateUseCase
{
    public function execute(array $data, int $id): array
    {
        $item = Wallet::findOrFail($id);
        $item->update([
            'name' => $data['name'],
            'amount' => $data['amount'],
            'hidden' => $data['hidden'],
            'status' => $data['status'],
        ]);
        return $item->refresh()->toArray();
    }
}
