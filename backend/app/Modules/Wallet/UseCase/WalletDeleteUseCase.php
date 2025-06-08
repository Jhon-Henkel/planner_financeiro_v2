<?php

namespace App\Modules\Wallet\UseCase;

use App\Infra\Response\Exceptions\BadRequestException;
use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Models\Wallet\Wallet;

class WalletDeleteUseCase implements IDeleteUseCase
{
    public function execute(int $id): void
    {
        $item = Wallet::find($id);

        if (is_null($item)) {
            return;
        }

        if ($item->movements()->exists()) {
            throw new BadRequestException('Não é possível excluir uma carteira que possui movimentações associadas.');
        }

        $item->delete();
    }
}
