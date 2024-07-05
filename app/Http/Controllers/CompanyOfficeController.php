<?php
// app/Http/Controllers/CompanyOfficeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyOffice;

class CompanyOfficeController extends Controller
{
    public function store(Request $request)
    {
        // Проверка роли пользователя
        if ($request->user()->role === 'admin') {
            // Валидация данных
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'company_id' => 'required|exists:companies,id',
            ]);

            // Создание нового офиса компании и сохранение его в базу данных
            $office = CompanyOffice::create($validatedData);

            return response()->json([
                'message' => 'Company office created successfully',
                'office' => $office,
            ], 201);
        } else {
            return response()->json([
                'error' => 'Only administrators can create company offices.'
            ], 403);
        }
    }
}
