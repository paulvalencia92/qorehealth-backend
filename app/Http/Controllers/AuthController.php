<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        try {
            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return response()->json(['errors' => [['El Correo electrónico o Contraseña no coinciden']]], 401);
            }

            $user = request()->user();
            $token = $user->createToken('Personal Access Client');

            Passport::tokensExpireIn(Carbon::now()->addYears(100));

            return response()->json([
                'user' => $user,
                'access_token' => $token->accessToken,
            ]);

        } catch (ValidationException $e) {
            return response()->json($e->validator->errors());
        }

    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Sesión cerrada con éxito', 200);

    }
}
