<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\sicialController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});
Route::get('auth/google/callback', [sicialController::class, 'handleGoogleCallback']);

Route::get('auth/callback', [sicialController::class, 'handleAuthCallback']);
Route::get('facebook/callback', [sicialController::class, 'handleFacebookCallback']);
Route::get('payment.success', [sicialController::class, 'handleFacebookCallback'])->name('payment.success');
Route::get('payment.cancel', [sicialController::class, 'handleFacebookCallback'])->name('payment.cancel');

Route::post('/webhook', [PaymentController::class, 'handleWebhook'])->name('webhook');
Route::post('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('api.payment.success');
Route::post('/payment-cancel', [PaymentController::class, 'paymentCancel'])->name('api.payment.cancel');
