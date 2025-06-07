<?php

use App\Infra\Route\Enum\RouteNameEnum;
use App\Modules\Auth\Controller\Login\LoginController;
use App\Modules\Wallet\Controller\WalletCreateController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', LoginController::class)->name(RouteNameEnum::ApiAuthLogin);
});

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    Route::prefix('wallet')->group(function () {
        Route::post('', WalletCreateController::class)->name(RouteNameEnum::ApiWalletCreate);
    });
});
