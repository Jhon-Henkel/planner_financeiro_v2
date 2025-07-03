<?php

use App\Infra\Route\Enum\RouteNameEnum;
use App\Modules\Auth\Controller\Login\LoginController;
use App\Modules\Expense\Controller\ExpenseCreateController;
use App\Modules\Expense\Controller\ExpenseGetController;
use App\Modules\Expense\Controller\ExpenseListController;
use App\Modules\Expense\Controller\ExpensePayController;
use App\Modules\Expense\Controller\ExpenseUpdateController;
use App\Modules\Movement\Controller\MovementCreateController;
use App\Modules\Movement\Controller\MovementDeleteController;
use App\Modules\Movement\Controller\MovementGetController;
use App\Modules\Movement\Controller\MovementListController;
use App\Modules\Movement\Controller\MovementUpdateController;
use App\Modules\Movement\Controller\Transfer\MovementTransferCreateController;
use App\Modules\Movement\Controller\Transfer\MovementTransferDeleteController;
use App\Modules\Wallet\Controller\WalletCreateController;
use App\Modules\Wallet\Controller\WalletDeleteController;
use App\Modules\Wallet\Controller\WalletDetailsController;
use App\Modules\Wallet\Controller\WalletGetController;
use App\Modules\Wallet\Controller\WalletListController;
use App\Modules\Wallet\Controller\WalletUpdateController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', LoginController::class)->name(RouteNameEnum::ApiAuthLogin);
});

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {

    Route::prefix('wallet')->group(function () {
        Route::get('details', WalletDetailsController::class)->name(RouteNameEnum::ApiWalletDetails);
        Route::get('', WalletListController::class)->name(RouteNameEnum::ApiWalletList);
        Route::post('', WalletCreateController::class)->name(RouteNameEnum::ApiWalletCreate);
        Route::prefix('{id}')->group(function () {
            Route::put('', WalletUpdateController::class)->name(RouteNameEnum::ApiWalletUpdate);
            Route::delete('', WalletDeleteController::class)->name(RouteNameEnum::ApiWalletDelete);
            Route::get('', WalletGetController::class)->name(RouteNameEnum::ApiWalletGet);
        });
    });

    Route::prefix('movement')->group(function () {
        Route::prefix('transfer')->group(function () {
            Route::post('', MovementTransferCreateController::class)->name(RouteNameEnum::ApiMovementTransferCreate);
            Route::delete('{id}', MovementTransferDeleteController::class)->name(RouteNameEnum::ApiMovementTransferDelete);
        });
        Route::get('', MovementListController::class)->name(RouteNameEnum::ApiMovementList);
        Route::post('', MovementCreateController::class)->name(RouteNameEnum::ApiMovementCreate);
        Route::prefix('{id}')->group(function () {
            Route::put('', MovementUpdateController::class)->name(RouteNameEnum::ApiMovementUpdate);
            Route::delete('', MovementDeleteController::class)->name(RouteNameEnum::ApiMovementDelete);
            Route::get('', MovementGetController::class)->name(RouteNameEnum::ApiMovementGet);
        });
    });

    Route::prefix('expense')->group(function () {
        Route::post('', ExpenseCreateController::class)->name(RouteNameEnum::ApiExpenseCreate);
        Route::get('', ExpenseListController::class)->name(RouteNameEnum::ApiExpenseList);
        Route::post('pay', ExpensePayController::class)->name(RouteNameEnum::ApiExpensePay);
        Route::prefix('{id}')->group(function () {
            Route::get('', ExpenseGetController::class)->name(RouteNameEnum::ApiExpenseGet);
            Route::put('', ExpenseUpdateController::class)->name(RouteNameEnum::ApiExpenseUpdate);
        });
    });
});
