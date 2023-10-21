<?php

use App\Http\Controllers\Api\ApiBeerController;
use App\Http\Controllers\Api\Auth\ApiLoginController;
use App\Http\Controllers\Api\Auth\ApiUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['as' => 'api.'], static function () {
    Route::post('/login', ApiLoginController::class)->name('login')->middleware('guest');

    /** Needs auth */
    Route::middleware('auth:sanctum')->group(static function () {
        Route::get('/beers', ApiBeerController::class)->name('beers');
        Route::get('/user', ApiUserController::class)->name('user');
    });
});
