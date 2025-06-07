<?php

namespace App\Modules\Wallet\Controller;

use App\Infra\Controller\Create\BaseCreateController;
use App\Infra\UseCase\Create\ICreateUseCase;
use App\Modules\Wallet\UseCase\WalletCreateUseCase;

class WalletCreateController extends BaseCreateController
{
    public function __construct(protected WalletCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCase
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'name' => 'required|max:255|min:2|string',
            'amount' => 'required|decimal:0,2',
            'hidden' => 'required|boolean',
        ];
    }
}
