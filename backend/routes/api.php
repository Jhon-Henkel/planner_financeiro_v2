<?php

use App\Infra\Route\Enum\RouteNameEnum;
use App\Modules\Auth\Controller\Login\LoginController;
use App\Modules\Movement\Controller\MovementCreateController;
use App\Modules\Movement\Controller\MovementDeleteController;
use App\Modules\Movement\Controller\MovementGetController;
use App\Modules\Movement\Controller\MovementListController;
use App\Modules\Movement\Controller\MovementUpdateController;
use App\Modules\Movement\Controller\Transfer\MovementTransferCreateController;
use App\Modules\Movement\Controller\Transfer\MovementTransferDeleteController;
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
            Route::post('', MovementTransferCreateController::class)->name(RouteNameEnum::ApiMovementTransferCreate);
            Route::delete('{id}', MovementTransferDeleteController::class)->name(RouteNameEnum::ApiMovementTransferDelete);
        });
        Route::post('', MovementCreateController::class)->name(RouteNameEnum::ApiMovementCreate);
        Route::put('{id}', MovementUpdateController::class)->name(RouteNameEnum::ApiMovementUpdate);
        Route::delete('{id}', MovementDeleteController::class)->name(RouteNameEnum::ApiMovementDelete);
        Route::get('{id}', MovementGetController::class)->name(RouteNameEnum::ApiMovementGet);
        Route::get('', MovementListController::class)->name(RouteNameEnum::ApiMovementList);
    });

});
