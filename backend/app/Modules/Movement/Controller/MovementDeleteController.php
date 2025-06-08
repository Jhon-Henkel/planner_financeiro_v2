<?php

namespace App\Modules\Movement\Controller;

use App\Infra\Controller\Delete\BaseDeleteController;
use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Modules\Movement\UseCase\MovementDeleteUseCase;
use App\Modules\Wallet\UseCase\WalletDeleteUseCase;

class MovementDeleteController extends BaseDeleteController
{
    public function __construct(protected MovementDeleteUseCase $useCase)
    {
    }

    protected function getUseCase(): IDeleteUseCase
    {
        return $this->useCase;
    }
}
