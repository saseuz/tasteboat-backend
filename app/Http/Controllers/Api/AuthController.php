<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RefreshTokenRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
            $validated = $request->validated();

            $user = User::create($validated);

            $response = Http::asForm()->post(route('passport.token'), [
                'grant_type' => 'password',
                'client_id' => config('passport.password_client_id'),
                'client_secret' => config('passport.password_client_secret'),
                'username' => $validated['email'],
                'password' =>  $validated['password'],
                'scope' => '',
            ]);

            $user['token'] = $response->json();

            return response()->json([
                'status' => 'success',
                'response_code' => 201,
                'message' => 'User has been registered successfully.',
                'data' => $user,
            ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $response = Http::asForm()->post(route('passport.token'), [
                'grant_type' => 'password',
                'client_id' => config('passport.password_client_id'),
                'client_secret' => config('passport.password_client_secret'),
                'username' => $request->email,
                'password' =>  $request->password,
                'scope' => '',
            ]);

            $user['token'] = $response->json();

            return response()->json([
                'status' => 'success',
                'response_code' => 200,
                'message' => 'User has been logged successfully.',
                'data' => $user,
            ], 200);

        } else {
            return response()->json([
                'status' => 'error',
                'response_code' => 401,
                'message' => 'Unauthorized.'
            ], 401);
        }
    }

    public function refreshToken(RefreshTokenRequest $request): JsonResponse
    {
        $response = Http::asForm()->post(route('passport.token'), [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => config('passport.password_client_id'),
            'client_secret' => config('passport.password_client_secret'),
            'scope' => '',
        ]);

        return response()->json([
            'status' => 'success',
            'response_code' => 201,
            'message' => 'Refreshed token.',
            'data' => $response->json(),
        ], 200);
    }

    public function profile(): JsonResponse
    {
        $user = auth()->user();

        return response()->json([
            'status' => 'success',
            'response_code' => 200,
            'message' => 'Authenticated user info.',
            'data' => $user,
        ], 200);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'response_code' => 200,
            'message' => 'Logged out successfully.',
        ], 200);
    }
}
