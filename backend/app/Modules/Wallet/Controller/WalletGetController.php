<?php

namespace App\Modules\Wallet\Controller;

use App\Infra\Controller\Read\BaseGetController;
use App\Infra\UseCase\Read\IGetUseCase;
use App\Modules\Wallet\UseCase\WalletGetUseCase;

class WalletGetController extends BaseGetController
{
    public function __construct(protected WalletGetUseCase $useCase)
    {
    }

    protected function getUseCase(): IGetUseCase
    {
        return $this->useCase;
    }
}
