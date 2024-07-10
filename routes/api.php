<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyOfficeController;
use App\Http\Controllers\UserController;

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::group(['prefix' => 'offices', 'middleware' => ['auth:sanctum']], function (){
    Route::get('/', [CompanyOfficeController::class, 'index']);
    Route::get('/{office_id}', [CompanyOfficeController::class, 'show']);
    Route::post('/', [CompanyOfficeController::class, 'store']);
    Route::delete('/{office_id}', [CompanyOfficeController::class, 'destroy']);

    // Дополнительные маршруты для работы с пользователями по офисам
    Route::get('/{office_id}/users', [CompanyOfficeController::class, 'getUsersByOffice']);
    Route::get('/{office_id}/users/sort', [CompanyOfficeController::class, 'sortUsersByOffice']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});
