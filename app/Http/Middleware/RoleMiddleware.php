<?php

namespace App\Http\Middleware;

use App\Http\Utilitis\RespuestasApi;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if(Auth::user()->role->name != $role)
        {
            return RespuestasApi::error('No tiene permisos para acceder a esta ruta', 403);
        }
        return $next($request);
    }
}
