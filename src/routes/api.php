<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

Route::post('/tohash', [LinkController::class, 'toHash'])
    ->name('tohash');

Route::get('/geturl/{hash}', [LinkController::class, 'getUrl'])
    ->name('geturl');

Route::get('/redirecturl/{hash}', [LinkController::class, 'redirectUrl'])
    ->name('redirecturl');

Route::post('/searchurl', [LinkController::class, 'searchUrl'])
    ->name('searchurl');


// Гет запрос для просмотра всех ссылок
Route::get('/links', [LinkController::class, 'links'])
    ->name('links');


