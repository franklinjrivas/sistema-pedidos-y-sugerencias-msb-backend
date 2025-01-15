<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\BasicAuthentication;
use App\Http\Middleware\JWTAuthentication;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware(BasicAuthentication::class);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(JWTAuthentication::class);
    Route::post('/check-intranet-url', [AuthController::class, 'check_intranet_url'])->middleware(JWTAuthentication::class);
});

Route::middleware(JWTAuthentication::class)->prefix('home')->group(function () {
    Route::post('/roles', [HomeController::class, 'roles']);
    Route::post('/menu', [HomeController::class, 'menu']);
    Route::post('/change-rol', [HomeController::class, 'change_rol']);
});
