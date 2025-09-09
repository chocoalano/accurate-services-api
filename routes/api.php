<?php

use App\Http\Controllers\Accurate\BillOfMaterialController;
use App\Http\Controllers\Accurate\BranchController;
use App\Http\Controllers\Accurate\CustomerController;
use App\Http\Controllers\Accurate\Sales\EmployeController;
use App\Http\Controllers\Accurate\Sales\SalesReturnController;
use App\Http\Controllers\Accurate\Warehouse\DeliveryController;
use App\Http\Controllers\Accurate\Warehouse\FinishGoodController;
use App\Http\Controllers\Accurate\Warehouse\WarehouseController;
use App\Http\Controllers\Accurate\Purchase\InvoiceController;
use App\Http\Controllers\Accurate\Purchase\OrderController;
use App\Http\Controllers\Accurate\Purchase\PaymentController;
use App\Http\Controllers\Accurate\Sales\SalesInvoiceController;
use App\Http\Controllers\Accurate\Sales\SalesOrderController;
use App\Http\Controllers\CredentialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// Public Route
Route::post('/login', [CredentialController::class, 'login']);

// Protected Routes (Require Authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [CredentialController::class, 'logout']);
    Route::get('/profile', [CredentialController::class, 'user']);

    Route::prefix('customer')
        ->controller(CustomerController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::get('create', 'create');
            Route::post('/', 'store');
            Route::get('{id}', 'show');
            Route::get('{id}/edit', 'edit');
            Route::put('/', 'update');
            Route::delete('{id}', 'destroy');
        });
    Route::prefix('sales-order')
        ->controller(SalesOrderController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::get('create', 'create');
            Route::post('/', 'store');
            Route::get('{id}', 'show');
            Route::get('{number}/{isclose}', 'close');
            Route::get('{id}/edit', 'edit');
            Route::put('/', 'update');
            Route::delete('{id}', 'destroy');
        });
    Route::prefix('sales-invoice')
        ->controller(SalesInvoiceController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::get('create', 'create');
            Route::post('/', 'store');
            Route::get('{id}/detail-invoice', 'showInvoice');
            Route::get('{id}', 'show');
            Route::get('{id}/edit', 'edit');
            Route::put('/', 'update');
            Route::delete('{id}', 'destroy');
        });
    Route::prefix('sales-return')
        ->controller(SalesReturnController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::get('create', 'create');
            Route::post('/', 'store');
            Route::get('{id}', 'show');
            Route::get('{id}/edit', 'edit');
            Route::get('/invoice/{customerNo}', 'showInvoice');
            Route::put('/', 'update');
            Route::delete('{id}', 'destroy');
        });
    Route::prefix('sales-employee')
        ->controller(EmployeController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::get('create', 'create');
            Route::post('/', 'store');
            Route::get('{id}', 'show');
            Route::get('{id}/edit', 'edit');
            Route::put('/', 'update');
            Route::delete('{id}', 'destroy');
        });
    Route::prefix('branch')
        ->controller(BranchController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::get('create', 'create');
            Route::post('/', 'store');
            Route::get('{id}', 'show');
            Route::get('{id}/edit', 'edit');
            Route::put('/', 'update');
            Route::delete('{id}', 'destroy');
        });
    Route::prefix('bill-of-material')
        ->controller(BillOfMaterialController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::get('create', 'create');
            Route::post('/', 'store');
            Route::get('{id}', 'show');
            Route::get('{id}/edit', 'edit');
            Route::put('/', 'update');
            Route::delete('{id}', 'destroy');
        });
    Route::prefix('warehouse')
        ->controller(WarehouseController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::get('create', 'create');
            Route::post('/', 'store');
            Route::get('{id}', 'show');
            Route::get('{id}/edit', 'edit');
            Route::put('/', 'update');
            Route::delete('{id}', 'destroy');
        });
    Route::prefix('finish-good')
        ->controller(FinishGoodController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::get('create', 'create');
            Route::post('/', 'store');
            Route::get('{id}', 'show');
            Route::get('{id}/edit', 'edit');
            Route::put('/', 'update');
            Route::delete('{id}', 'destroy');
        });
    Route::prefix('delivery')
        ->controller(DeliveryController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::get('create', 'create');
            Route::post('/', 'store');
            Route::get('{id}', 'show');
            Route::get('{id}/edit', 'edit');
            Route::put('/', 'update');
            Route::delete('{id}', 'destroy');
        });

    Route::prefix('purchase')->group(function () {
        Route::prefix('order')
            ->controller(OrderController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::get('create', 'create');
                Route::post('/', 'store');
                Route::get('{id}', 'show');
                Route::get('{id}/edit', 'edit');
                Route::put('/', 'update');
                Route::delete('{id}', 'destroy');
            });
        Route::prefix('invoice')
            ->controller(InvoiceController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::get('create', 'create');
                Route::get('/downpay/create', 'downpayForm');
                Route::post('/downpay', 'downpay');
                Route::post('/', 'store');
                Route::get('{id}', 'show');
                Route::get('{id}/edit', 'edit');
                Route::put('/', 'update');
                Route::delete('{id}', 'destroy');
            });
        Route::prefix('payment')
            ->controller(PaymentController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::get('create', 'create');
                Route::post('/', 'store');
                Route::get('{id}', 'show');
                Route::get('{id}/edit', 'edit');
                Route::put('/', 'update');
                Route::delete('{id}', 'destroy');
            });
    });
});
