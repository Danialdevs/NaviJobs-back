<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HttpResponse; // Используем алиас для разрешения констант

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return response()->json([
                'message' => 'Invalid login data'
            ], 401);
        }
        $token = Auth::user()->createToken('api-token');

        return [
            'token' => $token->plainTextToken
        ];
    }

}
