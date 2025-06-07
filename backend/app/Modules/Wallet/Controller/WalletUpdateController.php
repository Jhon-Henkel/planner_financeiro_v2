<?php

namespace App\Modules\Wallet\Controller;

use App\Infra\Controller\Update\BaseUpdateController;
use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\UseCase\Update\IUpdateUseCase;
use App\Modules\Wallet\UseCase\WalletUpdateUseCase;

class WalletUpdateController extends BaseUpdateController
{
    public function __construct(protected WalletUpdateUseCase $useCase)
    {
    }

    protected function getUseCase(): IUpdateUseCase
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'name' => 'required|max:255|min:2|string',
            'amount' => 'required|decimal:0,2',
            'hidden' => 'required|boolean',
            'status' => 'required|numeric|in:' . StatusActiveInactiveEnum::getForValidation(),
        ];
    }
}
