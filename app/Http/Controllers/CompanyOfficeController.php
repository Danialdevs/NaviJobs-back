<?php
// app/Http/Controllers/CompanyOfficeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyOffice;

class CompanyOfficeController extends Controller
{
    public function index(Request $request)
    {
        if($request->user()->role == 'admin'){
            $company_offices = CompanyOffice::where('company_id', $request->user()->company_id)->get();
            return response()->json($company_offices);
        }else{
            return response()->json([
                'error' => 'У вас '
            ], 403);
        }
    }
    public function show(Request $request, $office_id)
    {
        $office = CompanyOffice::findOrFail($office_id);
        return response()->json($office);
    }
    public function store(Request $request)
    {
        if ($request->user()->role === 'admin') {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
            ]);

            $office = CompanyOffice::create([
                'name' => $request->get('name'),
                'address' => $request->get('address'),
                'company_id' => $request->user()->company_id,
            ]);

            return response()->json([
                'message' => 'Company office created successfully',
                'office' => $office,
            ], 201);
        } else {
            return response()->json([
                'error' => 'Только админы могут сделать это'
            ], 403);
        }
    }
    public function destroy($id, Request $request)
    {
        // Найти офис компании по ID
        $office = CompanyOffice::findOrFail($id);

        // Проверка роли пользователя и принадлежности офиса администратору
        if ($request->user()->role == 'admin' && $request->user()->company_id === $office->company_id) {
            $office->delete();

            return response()->json([
                'message' => 'Компания успешна удалена',
            ]);
        } else {
            return response()->json([
                'error' => 'У вас недостаточно прав для этого',
            ], 403);
        }
    }
}
