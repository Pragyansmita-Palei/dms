<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('auth.login');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    // Customer area
    Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function() {
        Route::get('/orders', [CustomerOrderController::class,'index'])->name('orders.index');
        Route::post('/orders', [CustomerOrderController::class,'store'])->name('orders.store');

        Route::get('/pay/{order}', [PaymentController::class,'pay'])->name('pay');
    });

    // Payment callback (posted from checkout handler)
    Route::post('/payment/callback', [PaymentController::class,'callback'])->name('payment.callback');

    // Admin area
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function() {
        Route::resource('products', AdminProductController::class);
        Route::get('/orders', [AdminOrderController::class,'index'])->name('orders.index');
        Route::post('/orders/{order}/approve', [AdminOrderController::class,'approve'])->name('orders.approve');
        Route::post('/orders/{order}/reject', [AdminOrderController::class,'reject'])->name('orders.reject');
        Route::post('/orders/{order}/status', [AdminOrderController::class,'updateStatus'])->name('orders.status');
        Route::post('/orders/{order}/mark-paid', [AdminOrderController::class,'markPaid'])->name('orders.markpaid');
    });
});
