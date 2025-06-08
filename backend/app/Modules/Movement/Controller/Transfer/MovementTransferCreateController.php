<?php

namespace App\Modules\Movement\Controller\Transfer;

use App\Infra\Controller\Create\BaseCreateController;
use App\Infra\UseCase\Create\ICreateUseCase;
use App\Modules\Movement\UseCase\Transfer\MovementTransferCreateUseCase;

class MovementTransferCreateController extends BaseCreateController
{
    public function __construct(protected MovementTransferCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCase
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'from_id' => 'required|int|exists:App\Models\Wallet\Wallet,id',
            'to_id' => 'required|int|exists:App\Models\Wallet\Wallet,id',
            'amount' => 'required|decimal:0,2'
        ];
    }
}
