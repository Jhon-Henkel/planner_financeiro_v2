<?php

namespace App\Modules\Movement\Controller;

use App\Infra\Controller\Create\BaseCreateController;
use App\Infra\UseCase\Create\ICreateUseCase;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Movement\UseCase\MovementCreateUseCase;

class MovementCreateController extends BaseCreateController
{
    public function __construct(protected MovementCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCase
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'description' => 'required|string|max:255|min:2',
            'type' => 'required|int|in:' . MovementTypeEnum::getForValidation(),
            'wallet_id' => 'required|int|exists:App\Models\Wallet\Wallet,id',
            'amount' => 'required|decimal:0,2'
        ];
    }
}
