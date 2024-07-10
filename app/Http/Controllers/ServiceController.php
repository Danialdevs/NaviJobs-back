<?php
// app/Http/Controllers/ServiceController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $services = Service::all();

        return response()->json([
            'services' => $services,
        ]);
    }

    /**
     * Store a newly created service in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:0',
        ]);

        $service = Service::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => Hash::make($validatedData['price']),
            'duration_minutes' => $validatedData['duration_minutes'],
        ]);

        return response()->json([
            'message' => 'Пользователь успешно создан',
            'service' => $service,
        ], 201);
    }

    /**
     * Display the specified service.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);

        return response()->json([
            'service' => $service,
        ]);
    }


    /**
     * Update the specified service in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:0',
        ]);

        $service = Service::findOrFail($id);
        $service->update($validatedData);

        return response()->json([
            'message' => 'Service updated successfully',
            'service' => $service,
        ]);
    }

    /**
     * Remove the specified service from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json([
            'message' => 'Service deleted successfully',
        ]);
    }
}
