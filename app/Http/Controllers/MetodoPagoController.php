<?php

namespace App\Http\Controllers;

use App\Http\Requests\MetodoPagoRequest;
use App\Http\Resources\MetodoPagoResource;
use App\Http\Utilitis\RespuestasApi;
use App\Models\MetodoPago;
use Illuminate\Http\JsonResponse;

class MetodoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $metodosDePagos = (MetodoPago::all()->isEmpty()) ? 'Tabla vacia' : MetodoPagoResource::collection(MetodoPago::all());
        return RespuestasApi::success($metodosDePagos, 'Listado de Metodos de Pago');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MetodoPagoRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $metodo_pago = MetodoPago::create($validated);

        return RespuestasApi::success(new MetodoPagoResource($metodo_pago), 'Metodo de Pago Creado Satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $metodo_pago = MetodoPago::findOrFail($id);
        return RespuestasApi::success(new MetodoPagoResource($metodo_pago), 'Metodo de Pago Consultado Satisfactoriamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MetodoPagoRequest $request, string $id): JsonResponse
    {
        $metodo_pago = MetodoPago::findOrFail($id);
        $validated = $request->validated();
        $metodo_pago->update($validated);
        return RespuestasApi::success(new MetodoPagoResource($metodo_pago), 'Metodo de Pago Actualizado Satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $metodo_pago = MetodoPago::findOrFail($id);
        $metodo_pago->delete();
        return RespuestasApi::success(null, 'Metodo de Pago Eliminado Satisfactoriamente');
    }
}
