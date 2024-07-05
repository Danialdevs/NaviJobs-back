<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyOfficeController;


Route::group(['prefix' => 'offices', 'middleware' => ['auth:sanctum']], function (){
    Route::get('/', [CompanyOfficeController::class, 'index']);
    Route::get('/{office_id}', [CompanyOfficeController::class, 'show']);
    Route::post('/', [CompanyOfficeController::class, 'store']);
    Route::delete('/{office_id}', [CompanyOfficeController::class, 'destroy']);
});

Route::post('company_offices', [CompanyOfficeController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


