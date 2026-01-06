<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\FileUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user2', function (Request $request) {
    return $request->user();
})->middleware('passport_auth');

Route::post('/upload', [FileUploadController::class,'upload']);

// Route::controller(RegisterController::class);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('user', [AuthController::class, 'user'])->middleware('auth:api');
