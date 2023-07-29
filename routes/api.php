<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\HomeApiController;
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

Route::namespace('Api')->group(function (){
    Route::post('get_user_email', [AuthApiController::class, 'getUserEmail']);
    Route::post('user_login', [AuthApiController::class, 'userLogin']);
});

Route::namespace('Api')->middleware(['auth:sanctum'])->group(function (){
    Route::get('homepage', [HomeApiController::class, 'homepage']);
    Route::post('export_icons', [HomeApiController::class, 'exportIcons']);
});
