<?php

namespace App\Infra\UseCase\Read;

interface IGetUseCaseWithoutId
{
    public function execute(): array;
}
