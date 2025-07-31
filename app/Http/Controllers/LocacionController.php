<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocacionRequest;
use App\Http\Resources\LocacionResources;
use App\Http\Utilitis\RespuestasApi;
use App\Models\Locacion;
use Illuminate\Http\JsonResponse;

class LocacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $locaciones = (Locacion::all()->isEmpty()) ? 'Tabla vacia' : LocacionResources::collection(Locacion::all());

        return RespuestasApi::success($locaciones, 'Listado de Locaciones');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocacionRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $locacion = Locacion::create($validated);

        return RespuestasApi::success(new LocacionResources($locacion), 'Locacion created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $locacion = Locacion::findOrFail($id);

        return RespuestasApi::success(new LocacionResources($locacion));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocacionRequest $request, string $id): JsonResponse
    {
        $validated = $request->validated();

        $locacion = Locacion::findOrFail($id);

        $locacion->update($validated);

        return RespuestasApi::success(new LocacionResources($locacion), 'Locacion updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $locacion = Locacion::findOrFail($id);
        $locacion->delete();
        return RespuestasApi::success(null, 'Locacion deleted successfully');
    }
}
