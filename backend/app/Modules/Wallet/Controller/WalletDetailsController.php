<?php

namespace App\Modules\Wallet\Controller;

use App\Infra\Controller\Read\BaseGetControllerWithoutId;
use App\Infra\UseCase\Read\IGetUseCaseWithoutId;
use App\Modules\Wallet\UseCase\Actions\WalletDetailsUseCase;

class WalletDetailsController extends BaseGetControllerWithoutId
{
    public function __construct(protected WalletDetailsUseCase $useCase)
    {
    }

    protected function getUseCase(): IGetUseCaseWithoutId
    {
        return $this->useCase;
    }
}
