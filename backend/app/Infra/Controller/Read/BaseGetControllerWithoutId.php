<?php

namespace App\Infra\Controller\Read;

use App\Infra\Controller\Controller;
use App\Infra\Response\Api\ResponseApi;
use App\Infra\UseCase\Read\IGetUseCaseWithoutId;
use Illuminate\Http\JsonResponse;

abstract class BaseGetControllerWithoutId extends Controller
{
    abstract protected function getUseCase(): IGetUseCaseWithoutId;

    public function __invoke(): JsonResponse
    {
        $result = $this->getUseCase()->execute();
        return ResponseApi::renderOk($result);
    }
}
