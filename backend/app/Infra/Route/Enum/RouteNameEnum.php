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
    case ApiWalletDetails = 'api.wallet.details';

    case ApiMovementCreate = 'api.movement.create';
    case ApiMovementUpdate = 'api.movement.update';
    case ApiMovementDelete = 'api.movement.delete';
    case ApiMovementGet = 'api.movement.get';
    case ApiMovementList = 'api.movement.list';
    case ApiMovementDetails = 'api.movement.details';

    case ApiMovementTransferCreate = 'api.movement.transfer.create';
    case ApiMovementTransferDelete = 'api.movement.transfer.delete';
}
