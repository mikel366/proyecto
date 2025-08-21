<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetallePedido\CreateDetallePedidoRequest;
use App\Http\Requests\DetallePedido\UpdateDetallePedidoRequest;
use App\Http\Utilitis\RespuestasApi;
use App\Models\DetallePedido;
use Illuminate\Http\JsonResponse;

class DetallePedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        // $detalles = (DetallePedido::all()->isEmpty()) ? 'No hay detalle de pedidos' : DetallePedido::all();
        // return RespuestasApi::success($detalles);
        $detalles = DetallePedido::with('pedido', 'producto')->get();
        return RespuestasApi::success($detalles);
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        // $detalle = DetallePedido::findOrFail($id);
        // return RespuestasApi::success($detalle);
        $detalle = DetallePedido::with('pedido', 'producto')->findOrFail($id);
        return RespuestasApi::success($detalle);
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
}
