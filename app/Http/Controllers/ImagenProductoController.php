<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImagenProductoRequest;
use App\Http\Requests\UpdateImagenProductoRequest;
use App\Http\Resources\ImagenProductoResource;
use App\Http\Utilitis\RespuestasApi;
use App\Models\ImagenProducto;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ImagenProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $imagenes = ImagenProducto::with('producto')->paginate(10);
        return RespuestasApi::success(ImagenProductoResource::collection($imagenes), 'Listado de imágenes de productos', );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateImagenProductoRequest $request): JsonResponse
    {
        $producto = Producto::findOrFail($request->producto_id);

        foreach($request->file('images') as $imagen) {
            $ruta = $imagen->store('productos', 'public');

            $producto->imagenes()->create([
                'url' => "/storage/{$ruta}"
            ]);
        }

        return RespuestasApi::success('Imágenes subidas correctamente', ImagenProductoResource::collection($producto->imagenes()->get()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $imagen = ImagenProducto::findOrFail($id);

        return RespuestasApi::success('Imagen de producto', new ImagenProductoResource($imagen));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImagenProductoRequest $request, string $id): JsonResponse
    {
        $imagen = ImagenProducto::findOrFail($id);
        
        // Elimina la imagen anterior del storage
        if ($imagen->url && Storage::disk('public')->exists(str_replace('/storage/', '', $imagen->url))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $imagen->url));
        }

        // Guarda la nueva imagen
        $ruta = $request->file('image')->store('productos', 'public');
        $imagen->update([
            'url' => "/storage/{$ruta}"
        ]);

        return RespuestasApi::success('Imagen actualizada correctamente', new ImagenProductoResource($imagen));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $imagen = ImagenProducto::findOrFail($id);

        // Elimina el archivo del storage
        if ($imagen->url && Storage::disk('public')->exists(str_replace('/storage/', '', $imagen->url))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $imagen->url));
        }

        $imagen->delete();

        return RespuestasApi::success(null, 'Imagen eliminada correctamente');
    }
}
