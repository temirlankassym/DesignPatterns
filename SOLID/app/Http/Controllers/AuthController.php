<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function register(UserStoreRequest $request)
    {
        User::create($request->validated());

        return response()->json([
            'success' => true,
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token
            ]
        ]);
    }
}
