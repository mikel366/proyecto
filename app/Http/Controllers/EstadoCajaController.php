<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadoCajaRequest;
use App\Http\Resources\EstadoCajaResource;
use App\Http\Utilitis\RespuestasApi;
use App\Models\EstadoCaja;
use Illuminate\Http\JsonResponse;

class EstadoCajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $estadosCajas = (EstadoCaja::all()->isEmpty()) ? 'Tabla vacia' : EstadoCajaResource::collection(EstadoCaja::all());
        return RespuestasApi::success(EstadoCajaResource::collection($estadosCajas));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EstadoCajaRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $estadoCaja = EstadoCaja::create($validated);

        return RespuestasApi::success(new EstadoCajaResource($estadoCaja));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $estados = EstadoCaja::findOrFail($id);
        return RespuestasApi::success(new EstadoCajaResource($estados));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EstadoCajaRequest $request, string $id): JsonResponse
    {
        $estadoCaja = EstadoCaja::findOrFail($id);
        $estadoCaja->update($request->validated());
        return RespuestasApi::success(new EstadoCajaResource($estadoCaja));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $estadoCaja = EstadoCaja::findOrFail($id);
        $estadoCaja->delete();
        return RespuestasApi::success(null, 'Estado Caja deleted successfully');
    }
}
