<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyOfficeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::group(['prefix' => 'offices', 'middleware' => ['auth:sanctum']], function (){
    Route::get('/', [CompanyOfficeController::class, 'index']);
    Route::get('/{office_id}', [CompanyOfficeController::class, 'show']);
    Route::post('/', [CompanyOfficeController::class, 'store']);
    Route::delete('/{office_id}', [CompanyOfficeController::class, 'destroy']);

    // Дополнительные маршруты для работы с пользователями по офисам
    Route::get('/{office_id}/users', [CompanyOfficeController::class, 'getUsersByOffice']);
    Route::get('/{office_id}/users/sort', [CompanyOfficeController::class, 'sortUsersByOffice']);
    Route::post('/company-offices/{office_id}/users/{user_id}', [CompanyOfficeController::class, 'addUserToOffice']);
    Route::delete('/company-offices/{office_id}/users/{user_id}', [CompanyOfficeController::class, 'removeUserFromOffice']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});
Route::group(['prefix' => 'services', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', [ServiceController::class, 'index']);
    Route::get('/{id}', [ServiceController::class, 'show']);
    Route::post('/', [ServiceController::class, 'store']);
    Route::put('/{id}', [ServiceController::class, 'update']);
    Route::delete('/{id}', [ServiceController::class, 'destroy']);
});
