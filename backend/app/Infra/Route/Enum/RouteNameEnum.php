<?php

namespace App\Infra\Route\Enum;

enum RouteNameEnum: string
{
    case ApiAuthLogin = 'api.auth.login';

    case ApiWalletCreate = 'api.wallet.create';
    case ApiWalletUpdate = 'api.wallet.update';
}
