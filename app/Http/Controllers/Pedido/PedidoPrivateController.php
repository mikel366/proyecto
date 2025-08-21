<?php

namespace App\Http\Controllers\Pedido;

use App\Events\Pedido\EstadoPedidoActualizado;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pedidos\ActualizarEstadoRequest;
use App\Http\Requests\registrarVentaRequest;
use App\Http\Resources\Pedido\PedidoPrivateResource;
use App\Http\Utilitis\RespuestasApi;
use App\Models\Caja;
use App\Models\Pedido;
use App\Models\Producto;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoPrivateController extends Controller
{
    public function index(): JsonResponse
    {
        $pedidos = (Pedido::all()->isEmpty()) ? 'Tabla vacia' : PedidoPrivateResource::collection(Pedido::all());
        return RespuestasApi::success($pedidos);
    }
    public function show(string $id): JsonResponse
    {
        $pedido = Pedido::findOrFail($id);
        $pedido = new PedidoPrivateResource($pedido);
        return RespuestasApi::success($pedido);
    }
    public function actualizarEstado(string $id, ActualizarEstadoRequest $request): JsonResponse
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->update($request->validated());
        event(new EstadoPedidoActualizado($pedido));
        $pedido = new PedidoPrivateResource($pedido);
        return RespuestasApi::success($pedido);
    }

    public function registrarVenta(registrarVentaRequest $request): JsonResponse
    {
        if(!Caja::where('estado_caja_id', 1)->latest()->first()){
            return RespuestasApi::error('No hay caja abierta');
        }

        DB::beginTransaction();

        try {
            $total = 0;
            $detalles = [];
            $validated = $request->validated();
            
            foreach ($validated['productos'] as $item) {
                $producto = Producto::findOrFail($item['producto_id']);

                if ($producto->stock < $item['cantidad']) {
                    throw new Exception("Stock insuficiente para {$producto->nombre}");
                }

                $subtotal = $producto->precio * $item['cantidad'];
                $total += $subtotal;

                $detalles[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $subtotal,
                ];

                $producto->stock -= $item['cantidad'];
                $producto->save();
            }

            $pedido = Pedido::create([
                'user_id' => Auth::user()->id, // o null si no se asocia a un usuario
                'locacion_id' => null, // local
                'estado_id' => 2, // vendido o entregado
                'canal_venta_id' => 1, // mostrador
                'metodo_pago_id' => $validated['metodo_pago_id'],
                'caja_id' => Caja::where('estado_caja_id', 1)->latest()->first()->id,
                'total' => $total
            ]);

            foreach ($detalles as $detalle) {
                $pedido->detalles()->create($detalle);
            }

            DB::commit();

            return RespuestasApi::success(['pedido_id' => $pedido->id], 'Venta registrada correctamente');

        } catch (Exception $e) {
            DB::rollBack();
            return RespuestasApi::error($e->getMessage());
        }
    }

}