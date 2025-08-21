<?php

namespace App\Http\Controllers;

use App\Http\Requests\Caja\AbrirCajaRequest;
use App\Http\Requests\CajaRequest;
use App\Http\Resources\CajaResource;
use App\Models\Caja;
use Illuminate\Http\JsonResponse;
use App\Http\Utilitis\RespuestasApi;
use App\Models\Pedido;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $cajas = Caja::all();
        $data = $cajas->isEmpty() ? 'Tabla vacía' : CajaResource::collection($cajas);
        return RespuestasApi::success($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CajaRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $caja = Caja::create($validated);
        return RespuestasApi::success(new CajaResource($caja), 'Caja created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $caja = Caja::findOrFail($id);
        
        return RespuestasApi::success(new CajaResource($caja));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CajaRequest $request, string $id):JsonResponse
    {
        $caja = Caja::findOrFail($id);
        $validated = $request->validated();
        $caja->update($validated);
        return RespuestasApi::success(new CajaResource($caja), 'Caja updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):JsonResponse
    {
        $caja = Caja::findOrFail($id);
        $caja->delete();
        return RespuestasApi::success(null, 'Caja deleted successfully');
    }

    public function abrirCaja(AbrirCajaRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (Caja::where('estado_caja_id', 1)->exists()) {
            return RespuestasApi::error('Ya existe una caja abierta.', 400);
        }

        DB::beginTransaction();
        try {
            $caja = Caja::create([
                'user_id' => Auth::id(),
                'monto_apertura' => $validated['monto_apertura'] ?? 0,
                'estado_caja_id' => 1,
            ]);

            DB::commit();
            return RespuestasApi::success($caja, 'Caja abierta correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            return RespuestasApi::error($e->getMessage());
        }
    }


    public function cerrarCaja(): JsonResponse
    {
        // Podrías tener constantes en el modelo Caja para más claridad
        $ESTADO_ABIERTA = 1;
        $ESTADO_CERRADA = 2;
        $PEDIDO_COMPLETADO = 5;

        // Buscar caja abierta
        $caja = Caja::where('estado_caja_id', $ESTADO_ABIERTA)->latest()->first();

        if (!$caja) {
            return RespuestasApi::error('No hay ninguna caja abierta.', 404);
        }

        DB::beginTransaction();
        try {
            // Obtener pedidos completados asociados a esta caja
            $pedidos = Pedido::where('caja_id', $caja->id)
                ->where('estado_id', $PEDIDO_COMPLETADO)
                ->with('metodoPago')
                ->get();

            $total = $pedidos->sum('total');

            // Totales agrupados por método de pago
            $totalesPorMetodo = $pedidos->groupBy('metodo_pago_id')->map(fn($grupo) => $grupo->sum('total'));

            // Cerrar caja
            $caja->update([
                'estado_caja_id' => $ESTADO_CERRADA,
                'monto_cierre' => $total,
                'fecha_cierre' => now(),
            ]);

            DB::commit();

            return RespuestasApi::success([
                'monto_total' => $total,
                'ventas' => $pedidos,
                'totales_por_metodo' => $totalesPorMetodo,
                'mensaje' => 'Caja cerrada correctamente.'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return RespuestasApi::error($e->getMessage());
        }
    }



}
