<?php

namespace App\\Http\\Controllers;

use Illuminate\\Http\\Request;
use Illuminate\\Support\\Facades\\Auth;
use App\\Models\\User;
use Illuminate\\Support\\Facades\\Hash;
use Tymon\\JWTAuth\\Facades\\JWTAuth;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            \'email\' => \'required|string|email\',
            \'password\' => \'required|string\',
        ]);

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json([\'message\' => \'Unauthorized\'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Register a new user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            \'name\' => \'required|string|max:255\',
            \'email\' => \'required|string|email|max:255|unique:users\',
            \'password\' => \'required|string|min:6\',
            \'role\' => \'required|string|in:administrator,supervisor\'
        ]);

        $user = User::create([
            \'name\' => $validatedData[\'name\'],
            \'email\' => $validatedData[\'email\'],
            \'password\' => Hash::make($validatedData[\'password\']),\n            \'role\' => $validatedData[\'role\'],
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            \'message\' => \'User created successfully\',
            \'user\' => $user,
            \'authorisation\' => [
                \'token\' => $token,
                \'type\' => \'bearer\',
            ]
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return response()->json([\'message\' => \'Successfully logged out\']);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            \'access_token\' => $token,
            \'token_type\' => \'bearer\',
            \'user\' => Auth::user(),
            \'expires_in\' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
