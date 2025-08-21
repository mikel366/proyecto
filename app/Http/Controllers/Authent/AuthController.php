<?php

namespace App\Http\Controllers\Authent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Utilitis\RespuestasApi;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role_id' => User::ROLE_CLIENT
        ]);

        $userToken = $user->createToken('auth_token')->plainTextToken;

        return RespuestasApi::withTokenResponse(new AuthResource($user), 'User created successfully', $userToken);

    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (!Auth::attempt($validated)) {
            return RespuestasApi::error('Las credenciales proporcionadas son incorrectas', 401);
        }

        $user = User::where('email', $validated['email'])->first();

        $userToken = $user->createToken('auth_token')->plainTextToken;

        return RespuestasApi::withTokenResponse(new AuthResource($user), 'User authenticated successfully', $userToken);
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return RespuestasApi::success(null, 'Token revocado correctamente');
    }
   // Agregar este método al AuthController.php
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $validated = $request->validated();
        
        $user = Auth::user();
        $user->password = $validated['password'];
        $user->save();
        
        return RespuestasApi::success(null, 'Contraseña actualizada correctamente');
    }
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? RespuestasApi::success(null, 'Enlace de recuperación enviado a tu correo')
            : RespuestasApi::error('No se pudo enviar el enlace de recuperación', 400);
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
            ? RespuestasApi::success(null, 'Contraseña restablecida correctamente')
            : RespuestasApi::error('No se pudo restablecer la contraseña', 400);
    }
} 
