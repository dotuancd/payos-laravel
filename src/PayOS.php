<?php

namespace PayOS\Laravel;

use Illuminate\Support\Facades\Route;

class PayOS {

    public static function routes($prefix = null)
    {
        Route::group(['prefix' => $prefix], function () {
            Route::get('/checkout', function () {
                return view('payos::checkout');
            })->name('payos.checkout');

            Route::get('/success.html', function () {
                return view('payos::success');
            })->name('payos.success');

            Route::get('/cancel.html', function () {
                return view('payos::cancel');
            })->name('payos.cancel');

            Route::post('/create-payment-link', [\App\Http\Controllers\CheckoutController::class, 'createPaymentLink']);

            Route::prefix('/order')->group(function () {
                Route::post('/create', [\App\Http\Controllers\OrderController::class, 'createOrder']);
                Route::get('/{id}', [\App\Http\Controllers\OrderController::class, 'getPaymentLinkInfoOfOrder']);
                Route::put('/{id}', [\App\Http\Controllers\OrderController::class, 'cancelPaymentLinkOfOrder']);
            });

            Route::prefix('/payment')->group(function () {
                Route::post('/payos', [\App\Http\Controllers\PaymentController::class, 'handlePayOSWebhook']);
            });
        });
    }
}
