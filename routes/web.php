<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//Rotas de testes
Route::get('/testes', function () {
    return view('testes', ['name' => 'Samantha']);
});




Route::get('/form', [PostController::class, 'create']);
Route::post('/form', [PostController::class, 'store'])->name('form.store');


Route::get('/input_teste', function(){
    return view('input_teste');
});