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
    public function store(CreateDetallePedidoRequest $request): JsonResponse
    {
        // $detalle = DetallePedido::create($request->validated());
        // return RespuestasApi::success($detalle, 'Detalle de pedido creado con éxito', 201);
        $validated = $request->validated();
        $validated['subtotal'] = $validated['cantidad'] * $validated['precio_unitario'];
        $detalle = DetallePedido::create($validated);
        return RespuestasApi::success($detalle, 'Detalle de pedido creado con éxito', 201);
    }

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
    public function update(UpdateDetallePedidoRequest $request, string $id): JsonResponse
    {
        // $detalle = DetallePedido::findOrFail($id);
        // $detalle->update($request->validated());
        // return RespuestasApi::success($detalle, 'Detalle de pedido actualizado con éxito', 200);
        $validated = $request->validated();
        $validated['subtotal'] = $validated['cantidad'] * $validated['precio_unitario'];
        $detalle = DetallePedido::findOrFail($id);
        $detalle->update($validated);
        return RespuestasApi::success($detalle, 'Detalle de pedido actualizado con éxito', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $detalle = DetallePedido::findOrFail($id);
        $detalle->delete();
        return RespuestasApi::success(null, 'Detalle de pedido eliminado con éxito', 200);
    }
}
