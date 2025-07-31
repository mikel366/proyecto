<?php

namespace App\Http\Controllers;

use App\Http\Requests\CajaRequest;
use App\Http\Resources\CajaResource;
use App\Models\Caja;
use Illuminate\Http\JsonResponse;
use App\Http\Utilitis\RespuestasApi;

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
}
