<?php

namespace App\Http\Middleware\Caja;

use App\Http\Utilitis\RespuestasApi;
use App\Models\Caja;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarCajaAbierta
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Caja::where('estado_caja_id', 1)->exists()) {
            return RespuestasApi::error('No hay caja abierta', 403);
        }


        return $next($request);
    }
}
