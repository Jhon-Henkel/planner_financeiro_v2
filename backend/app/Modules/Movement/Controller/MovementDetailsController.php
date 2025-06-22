<?php

namespace App\Modules\Movement\Controller;

use App\Infra\Controller\Read\BaseGetControllerWithoutId;
use App\Infra\UseCase\Read\IGetUseCaseWithoutId;
use App\Modules\Movement\UseCase\MovementDetailsUseCase;

class MovementDetailsController extends BaseGetControllerWithoutId
{
    public function __construct(protected MovementDetailsUseCase $useCase)
    {
    }

    protected function getUseCase(): IGetUseCaseWithoutId
    {
        return $this->useCase;
    }
}
