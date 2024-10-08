<?php

use App\Http\Controllers\LinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/tohash', [LinkController::class, 'toHash'])
    ->name('tohash');

Route::get('/geturl/{hash}', [LinkController::class, 'getUrl'])
    ->name('geturl');

Route::get('/redirecturl/{hash}', [LinkController::class, 'redirectUrl'])
    ->name('redirecturl');

Route::get('/searchurl/{url}', [LinkController::class, 'searchUrl'])
    ->name('searchurl');

Route::get('/links', [LinkController::class, 'links'])
    ->name('links');

//Route::get('/links', [LinkController::class, 'links'])->name('links');


