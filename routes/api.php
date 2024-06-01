<?php

use App\Http\Controllers\ParkingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth;
use App\Http\Controllers\Api\V1\VehicleController;
use App\Http\Controllers\Api\V1\ZoneController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/profile', [Auth\ProfileController::class, 'show']);
    Route::put('/profile', [Auth\ProfileController::class, 'update']);
    Route::post('/reset-password', Auth\PasswordController::class);
    Route::post('/auth/logout', Auth\LogoutController::class);
    Route::apiResource('vehicles', VehicleController::class);
    Route::get('zones', [ZoneController::class, 'index']);

    Route::post('parkings/start', [ParkingController::class, 'start']);
    Route::put('parkings/{parking}', [ParkingController::class, 'stop']);
    Route::get('parkings/{parking}', [ParkingController::class, 'show']);
});

Route::post('/auth/register', Auth\RegisterController::class);
Route::post('/auth/login', Auth\LoginController::class);
