<?php

namespace App\Modules\Movement\UseCase;

use App\Infra\UseCase\Read\IGetUseCaseWithoutId;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;

class MovementDetailsUseCase implements IGetUseCaseWithoutId
{
    public function execute(): array
    {
        $received = Movement::where('type', MovementTypeEnum::Received->value)->sum('amount');
        $spent = Movement::where('type', MovementTypeEnum::Spent->value)->sum('amount');

        return [
            'received' => $received,
            'spent' => $spent,
            'balance' => round($received - $spent, 2),
        ];
    }
}
