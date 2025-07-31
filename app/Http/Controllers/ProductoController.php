<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Http\Resources\ProductoResource;
use App\Http\Utilitis\RespuestasApi;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $productos = Producto::with('imagenes')->paginate(10);
        $productos = ProductoResource::collection($productos);
        return RespuestasApi::success($productos);
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(CreateProductoRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $producto = Producto::create($validated);
        $producto = new ProductoResource($producto);
        return RespuestasApi::success($producto);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $producto = Producto::findOrFail($id);
        $producto = new ProductoResource($producto);
        return RespuestasApi::success($producto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoRequest $request, string $id): JsonResponse
    {
        $validated = $request->validated();

        $producto = Producto::findOrFail($id);

        $producto->update($validated);
        $producto = new ProductoResource($producto);
        return RespuestasApi::success($producto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return RespuestasApi::success(null, 'Producto eliminado exitosamente');
    }
}
