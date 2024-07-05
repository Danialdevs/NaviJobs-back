<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyOfficeController;


Route::get('companies/{company_id}/office/{office_id}', [CompanyOfficeController::class, 'Check_role']);

Route::post('company_offices', [CompanyOfficeController::class, 'store']);

Route::post('login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


