<?php

use Illuminate\Support\Facades\Route;

Route::get('/stripe', function () {
    // Lógica para lidar com o webhook do Stripe
    return response('Webhook Stripe recebido com sucesso!', 200);
})->name('stripe');

Route::get('/paypal', function () {
    // Lógica para lidar com o webhook do PayPal
    return response('Webhook PayPal recebido com sucesso!', 200);
})->name('paypal');
