<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovimientoCajaRequest;
use App\Http\Utilitis\RespuestasApi;
use App\Models\Caja;
use App\Models\MovimientoCaja;
use Exception;
use Illuminate\Http\JsonResponse;

class MovimientoCajaController extends Controller
{
    public function registrarMovimiento(MovimientoCajaRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try
        {
            $caja = Caja::where('estado_caja_id', 1)->latest()->first();
            if(!$caja)
            {
                throw new Exception('No hay caja abierta');
            }
            $movimiento = MovimientoCaja::create([
                'caja_id' => $caja->id,
                'tipo' => $validated['tipo'],
                'monto' => $validated['monto'],
                'motivo' => $validated['motivo'],
                'user_id' => auth()->user()->id,
            ]);
            return RespuestasApi::success($movimiento, 'Movimiento registrado');
        }
        catch(Exception $e)
        {
            return RespuestasApi::error($e->getMessage(), 400);
        }
    }

    public function actualizarMovimiento(MovimientoCajaRequest $request, string $id): JsonResponse
    {
        try {
            $movimiento = MovimientoCaja::findOrFail($id);
            if (!$movimiento) {
                throw new Exception('Movimiento no encontrado');
            }
            $movimiento->update($request->validated());
            return RespuestasApi::success($movimiento, 'Movimiento actualizado');
        } catch (Exception $e) {
            return RespuestasApi::error($e->getMessage(), 400);
        }
    }


    public function listarMovimientos(): JsonResponse
    {
        try {
            $caja = Caja::where('estado_caja_id', 1)->latest()->first();

            if (!$caja) {
                return RespuestasApi::error('No hay ninguna caja abierta.', 400);
            }

            $movimientos = $caja->movimientos()->orderBy('created_at', 'desc')->get();

            return RespuestasApi::success($movimientos);
        } catch (Exception $e) {
            return RespuestasApi::error($e->getMessage());
        }
    }
}
