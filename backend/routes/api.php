<?php

use App\Infra\Route\Enum\RouteNameEnum;
use App\Modules\Auth\Controller\Login\LoginController;
use App\Modules\Movement\Controller\MovementCreateController;
use App\Modules\Wallet\Controller\WalletCreateController;
use App\Modules\Wallet\Controller\WalletDeleteController;
use App\Modules\Wallet\Controller\WalletGetController;
use App\Modules\Wallet\Controller\WalletListController;
use App\Modules\Wallet\Controller\WalletUpdateController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', LoginController::class)->name(RouteNameEnum::ApiAuthLogin);
});

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {

    Route::prefix('wallet')->group(function () {
        Route::post('', WalletCreateController::class)->name(RouteNameEnum::ApiWalletCreate);
        Route::put('{id}', WalletUpdateController::class)->name(RouteNameEnum::ApiWalletUpdate);
        Route::delete('{id}', WalletDeleteController::class)->name(RouteNameEnum::ApiWalletDelete);
        Route::get('{id}', WalletGetController::class)->name(RouteNameEnum::ApiWalletGet);
        Route::get('', WalletListController::class)->name(RouteNameEnum::ApiWalletList);
    });

    Route::prefix('movement')->group(function () {
        Route::prefix('transfer')->group(function () {
            // transfer routes can be added here
        });

        Route::post('', MovementCreateController::class)->name(RouteNameEnum::ApiMovementCreate);
    });

});
