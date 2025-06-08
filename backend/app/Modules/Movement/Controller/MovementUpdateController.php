<?php

namespace App\Modules\Movement\Controller;

use App\Infra\Controller\Update\BaseUpdateController;
use App\Infra\UseCase\Update\IUpdateUseCase;
use App\Modules\Movement\UseCase\MovementUpdateUseCase;

class MovementUpdateController extends BaseUpdateController
{
    public function __construct(protected MovementUpdateUseCase $useCase)
    {
    }

    protected function getUseCase(): IUpdateUseCase
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'description' => 'required|string|max:255|min:2',
            'amount' => 'required|decimal:0,2'
        ];
    }
}
