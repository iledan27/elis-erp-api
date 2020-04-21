<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//get token for login
Route::post('/login', 'LoginController@login')->name('login');
Route::middleware('signed')->get('/verifyDevice/{id}/{hash}', 'LoginController@verifyDevice')->name('verification.device');

Route::middleware('auth:api')->group(function () {
    Route::middleware('throttle:100,10')->get('/registerDevice', 'LoginController@registerDevice')->name('register.device');

    Route::middleware('verify.device')->group(function () {
        Route::apiResource('/products', 'ProductsController');
    });
});


