<?php

use Illuminate\Http\Request;
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

Route::post('/login', \App\Http\Controllers\Api\Auth\ApiLoginController::class)->name('api.login');
Route::middleware('auth:sanctum')->get('/beers', \App\Http\Controllers\Api\ApiBeerController::class)->name('api.beers');
Route::middleware('auth:sanctum')->get('/user', fn (Request $request) => $request->user());
