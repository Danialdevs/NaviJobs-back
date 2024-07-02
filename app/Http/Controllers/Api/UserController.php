<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HttpResponse; // Используем алиас для разрешения констант

class UserController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');

        /** @var User|null $user */
        $user = Auth::guard('web')->user();

        if (!$user || !Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
            return response()->json([
                'message' => 'Неверный логин или пароль',
            ], HttpResponse::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('login');

        $user->update(['api_token' => $token->plainTextToken]);

        return response()->json([
            'message' => 'Успешный вход в систему',
        ], HttpResponse::HTTP_OK);
    }
}
