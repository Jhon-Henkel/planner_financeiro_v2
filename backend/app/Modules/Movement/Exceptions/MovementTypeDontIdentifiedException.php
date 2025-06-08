<?php

namespace App\Modules\Movement\Exceptions;

use App\Infra\Response\Exceptions\BadRequestException;

class MovementTypeDontIdentifiedException extends BadRequestException
{
    public function __construct()
    {
        parent::__construct('Tipo de movimento não identificado!');
    }
}
