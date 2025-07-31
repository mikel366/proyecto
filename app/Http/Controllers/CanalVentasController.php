<?php

namespace App\Http\Controllers;

use App\Http\Requests\CanalVentasRequest;
use App\Http\Resources\CanalVentasResource;
use App\Http\Utilitis\RespuestasApi;
use App\Models\CanalVenta;
use Illuminate\Http\JsonResponse;

class CanalVentasController extends Controller
{
    public function index(): JsonResponse
    {
        $canalVentas = (CanalVenta::all()->isEmpty()) ? 'Tabla vacia' : CanalVentasResource::collection(CanalVenta::all());
        return RespuestasApi::success($canalVentas);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CanalVentasRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $canalVenta = CanalVenta::create($validated);
        return RespuestasApi::success(new CanalVentasResource($canalVenta), 'Canal Venta created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $canalVenta = CanalVenta::findOrFail($id);
        return RespuestasApi::success(new CanalVentasResource($canalVenta));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CanalVentasRequest $request, string $id): JsonResponse
    {
        $canalVenta = CanalVenta::findOrFail($id);
        $canalVenta->update($request->validated());
        return RespuestasApi::success(new CanalVentasResource($canalVenta), 'Canal Venta updated successfully');
    }

    public function destroy(string $id): JsonResponse
    {
        $canalVenta = CanalVenta::findOrFail($id);
        $canalVenta->delete();
        return RespuestasApi::success(null, 'Canal Venta deleted successfully');
    }
}
