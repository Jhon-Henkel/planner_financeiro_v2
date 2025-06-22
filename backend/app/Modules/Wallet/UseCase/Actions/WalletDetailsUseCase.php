<?php

namespace App\Modules\Wallet\UseCase\Actions;

use App\Infra\UseCase\Read\IGetUseCaseWithoutId;
use App\Models\Wallet\Wallet;

class WalletDetailsUseCase implements IGetUseCaseWithoutId
{
    public function execute(): array
    {
        $visible = Wallet::where('hidden', false)->sum('amount');
        $hidden = Wallet::where('hidden', true)->sum('amount');

        return [
            'visible' => $visible,
            'hidden' => $hidden,
            'total' => round($visible + $hidden, 2),
        ];
    }
}
