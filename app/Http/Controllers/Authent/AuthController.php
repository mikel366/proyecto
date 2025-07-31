<?php

namespace App\Http\Controllers\Authent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully',
            'data' => new AuthResource($user),
            'token' => $user->createToken('auth_token')->plainTextToken
        ]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (!Auth::attempt($validated)) {
            return response()->json([
                'status' => false,
                'message' => 'Las credenciales proporcionadas son incorrectas'
            ], 401);
        }

        $user = User::where('email', $validated['email'])->first();

        return response()->json([
            'status' => true,
            'message' => 'Usuario autenticado correctamente',
            'data' => new AuthResource($user),
            'token' => $user->createToken('auth_token')->plainTextToken
        ]);
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Token revocado correctamente'
        ]);
    }
   // Agregar este método al AuthController.php
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $validated = $request->validated();
        
        $user = Auth::user();
        $user->password = $validated['password'];
        $user->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Contraseña actualizada correctamente'
        ]);
    }
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['status' => true, 'message' => 'Enlace de recuperación enviado a tu correo'])
            : response()->json(['status' => false, 'message' => 'No se pudo enviar el enlace de recuperación'], 400);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['status' => true, 'message' => 'Contraseña restablecida correctamente'])
            : response()->json(['status' => false, 'message' => 'No se pudo restablecer la contraseña'], 400);
    }
}
