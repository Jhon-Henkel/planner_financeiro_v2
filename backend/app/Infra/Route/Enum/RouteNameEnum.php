<?php

namespace App\Infra\Route\Enum;

enum RouteNameEnum: string
{
    case ApiAuthLogin = 'api.auth.login';

    case ApiWalletCreate = 'api.wallet.create';
    case ApiWalletUpdate = 'api.wallet.update';
    case ApiWalletDelete = 'api.wallet.delete';
    case ApiWalletGet = 'api.wallet.get';
    case ApiWalletList = 'api.wallet.list';

    case ApiMovementCreate = 'api.movement.create';
    case ApiMovementUpdate = 'api.movement.update';
}
