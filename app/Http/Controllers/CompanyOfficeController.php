<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyOffice;
use App\Models\User;

class CompanyOfficeController extends Controller
{
    /**
     * Получить список офисов компании для админа.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'error' => 'Только админы могут получить список офисов'
            ], 403);
        }

        $company_offices = CompanyOffice::where('company_id', $request->user()->company_id)->get();

        return response()->json($company_offices);
    }

    /**
     * Получить информацию об офисе компании.
     *
     * @param  int  $office_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $office_id)
    {
        $office = CompanyOffice::findOrFail($office_id);

        if ($request->user()->role !== 'admin' || $office->company_id !== $request->user()->company_id) {
            return response()->json([
                'error' => 'У вас нет прав на просмотр этого офиса'
            ], 403);
        }

        return response()->json($office);
    }

    /**
     * Создать новый офис компании.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'error' => 'Только админы могут создать новый офис'
            ], 403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $office = CompanyOffice::create([
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'company_id' => $request->user()->company_id,
        ]);

        return response()->json([
            'message' => 'Офис компании успешно создан',
            'office' => $office,
        ], 201);
    }

    /**
     * Удалить офис компании.
     *
     * @param  int  $office_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $office_id)
    {
        $office = CompanyOffice::findOrFail($office_id);

        if ($request->user()->role !== 'admin' || $office->company_id !== $request->user()->company_id) {
            return response()->json([
                'error' => 'У вас нет прав на удаление этого офиса'
            ], 403);
        }

        $office->delete();

        return response()->json([
            'message' => 'Офис компании успешно удалён',
        ]);
    }

    /**
     * Получить пользователей по офису.
     *
     * @param Request $request
     * @param int $office_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersByOffice(Request $request, $office_id)
    {
        // Проверка прав доступа
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'error' => 'Только администраторы могут получать список пользователей по офису'
            ], 403);
        }

        // Найти офис по ID
        $office = CompanyOffice::findOrFail($office_id);

        // Проверка, что офис принадлежит той же компании, что и пользователь
        if ($office->company_id !== $request->user()->company_id) {
            return response()->json([
                'error' => 'Этот офис не принадлежит вашей компании'
            ], 403);
        }

        // Получить пользователей этого офиса
        $users = User::where('office_id', $office_id)->get();

        return response()->json([
            'users' => $users
        ]);
    }

    /**
     * Сортировать пользователей по офису.
     *
     * @param Request $request
     * @param int $office_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function sortUsersByOffice(Request $request, $office_id)
    {
        // Проверка прав доступа
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'error' => 'Только администраторы могут сортировать пользователей по офису'
            ], 403);
        }

        // Найти офис по ID
        $office = CompanyOffice::findOrFail($office_id);

        // Проверка, что офис принадлежит той же компании, что и пользователь
        if ($office->company_id !== $request->user()->company_id) {
            return response()->json([
                'error' => 'Этот офис не принадлежит вашей компании'
            ], 403);
        }

        // Получить пользователей этого офиса и отсортировать их
        $users = User::where('office_id', $office_id)
            ->orderBy('name') // Пример сортировки по имени, можно изменить
            ->get();

        return response()->json([
            'users' => $users
        ]);
    }
    /**
     * Добавить пользователя к офису.
     *
     * @param Request $request
     * @param int $office_id
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function addUserToOffice(Request $request, $office_id, $user_id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'error' => 'Только администраторы могут добавлять пользователей к офису'
            ], 403);
        }

        $office = CompanyOffice::findOrFail($office_id);

        if ($office->company_id !== $request->user()->company_id) {
            return response()->json([
                'error' => 'Этот офис не принадлежит вашей компании'
            ], 403);
        }

        $user = User::findOrFail($user_id);

        $user->office_id = $office_id;
        $user->save();

        return response()->json([
            'message' => 'Пользователь успешно добавлен к офису',
            'user' => $user
        ]);
    }
    public function removeUserFromOffice(Request $request, $office_id, $user_id)
    {
        // Проверка прав доступа
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'error' => 'Только администраторы могут удалять пользователей из офиса'
            ], 403);
        }

        // Найти офис по ID
        $office = CompanyOffice::findOrFail($office_id);

        // Проверка, что офис принадлежит той же компании, что и пользователь
        if ($office->company_id !== $request->user()->company_id) {
            return response()->json([
                'error' => 'Этот офис не принадлежит вашей компании'
            ], 403);
        }

        // Найти пользователя по ID
        $user = User::findOrFail($user_id);

        // Проверка, что пользователь находится в указанном офисе
//        if ($user->office_id !== $office_id) {
//            return response()->json([
//                'error' => 'Пользователь не находится в указанном офисе'
//            ], 400);
//        }

        // Удалить связь пользователя с офисом
        $user->office_id = null;
        $user->save();

        return response()->json([
            'message' => 'Пользователь успешно удалён из офиса',
        ]);
    }
}
