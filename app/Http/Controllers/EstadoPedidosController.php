<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadoPedidosRequest;
use App\Http\Resources\EstadoPedidosResource;
use App\Http\Utilitis\RespuestasApi;
use App\Models\EstadoPedido;
use Illuminate\Http\JsonResponse;


class EstadoPedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $estadosPedidos = (EstadoPedido::all()->isEmpty()) ? 'Tabla vacia' : EstadoPedidosResource::collection(EstadoPedido::all());
        return RespuestasApi::success($estadosPedidos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EstadoPedidosRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $estadoPedido = EstadoPedido::create($validated);
        return RespuestasApi::success(new EstadoPedidosResource($estadoPedido), 'Estado Pedido created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $estados = EstadoPedido::findOrFail($id);
        return RespuestasApi::success(new EstadoPedidosResource($estados));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EstadoPedidosRequest $request, string $id): JsonResponse
    {
        $validated = $request->validated();
        $estado = EstadoPedido::findOrFail($id);
        $estado->update($validated);
        return RespuestasApi::success(new EstadoPedidosResource($estado));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $estadoPedido = EstadoPedido::findOrFail($id);
        $estadoPedido->delete();
        return RespuestasApi::success(null, 'Estado Pedido eliminado correctamente', 204);
    }
}
