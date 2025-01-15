<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Middleware\EmployeeMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AdminOrEmployeeMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', AdminOrEmployeeMiddleware::class])->group(function () {

    Route::post('/create-customer', [AuthController::class, 'createCustomer']);
});


Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {

    Route::post('/create-user', [AuthController::class, 'createUser']);
    Route::post('/assign-customer', [AuthController::class, 'assignCustomerToEmployee']);
});

Route::middleware(['auth:sanctum', EmployeeMiddleware::class])->group(function () {

    Route::post('/create-action', [EmployeeController::class, 'AddActionToCustomer']);
});
