<?php

namespace App\Http\Controllers\Pedido;

use App\Events\Pedido\EstadoPedidoActualizado;
use App\Events\Pedido\PedidoCreado;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pedidos\CreatePedidoRequest;
use App\Http\Resources\Pedido\PedidoPublicResource;
use App\Http\Utilitis\RespuestasApi;
use App\Models\Caja;
use App\Models\Pedido;
use App\Models\Producto;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoPublicController extends Controller
{
    //Metodos del lado publico
    public function crearPedido(CreatePedidoRequest $request)
    {
        DB::beginTransaction();

        try {
            $total = 0;
            $detalles = [];
            $validated = $request->validated();
            $productos = $validated['productos'];
            foreach ($productos as $item) {
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

                // Descontar stock
                $producto->stock -= $item['cantidad'];
                $producto->save();
            }
            // Crear pedido
            $pedido = Pedido::create([
                'user_id' => Auth::user()->id,
                'locacion_id' => $validated['locacion_id'],
                'estado_id' => 1, // pendiente
                'canal_venta_id' => 2,
                'metodo_pago_id' => $validated['metodo_pago_id'],
                'caja_id' => Caja::where('estado_caja_id', 1)->latest()->first()->id,
                'total' => $total
            ]);

            // Después de guardar los detalles
            foreach ($detalles as $detalle) {
                $pedido->detalles()->create($detalle);
            }

            // Disparar evento
            event(new PedidoCreado($pedido));

            DB::commit();
            return RespuestasApi::success(['pedido_id' => $pedido->id], 'Pedido Creado Satisfactoriamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return RespuestasApi::error($e->getMessage());
        }
    }


    public function mostrarPedidoPublic(string $id): JsonResponse
    {
        try {
            $userId = Auth::user()->id;
            $pedido = Pedido::where('id', $id)->where('user_id', $userId)->firstOrFail();
            return RespuestasApi::success(new PedidoPublicResource($pedido), 'Pedido Consultado Satisfactoriamente');
        } catch (Exception $e) {
            return RespuestasApi::error($e->getMessage());
        }
    }

    public function listarMisPedidos(): JsonResponse
    {
        try {
            $userId  = Auth::user()->id;
            $pedidos = Pedido::with('detalles.producto')->where('user_id', $userId)->get();
            if($pedidos->isEmpty())
            {
                return RespuestasApi::success(PedidoPublicResource::collection($pedidos), 'No tiene pedidos');
            }
            return RespuestasApi::success(PedidoPublicResource::collection($pedidos), 'Pedidos Consultado Satisfactoriamente');
        } catch (Exception $e) {
            return RespuestasApi::error($e->getMessage());
        }
    }

    public function cancelarPedido(string $id): JsonResponse
    {
        try {
            $userId = Auth::user()->id;
            $pedido = Pedido::where('id', $id)->where('user_id', $userId)->firstOrFail();

            if ($pedido->estado_id !== 1) {
                throw new Exception('El pedido no está en un estado que permita cancelación.');
            }

            // Verifica si el pedido ya superó los 5 minutos desde su creación
            $minRestantes = 5 - $pedido->created_at->diffInMinutes(now());

            if ($minRestantes <= 0) {
                throw new Exception('El pedido ya no puede ser cancelado después de 5 minutos.');
            }

            // Cambiar estado a cancelado (3)
            $pedido->estado_id = 3;
            $pedido->save();

            event(new EstadoPedidoActualizado($pedido));

            return RespuestasApi::success(null, 'Pedido Cancelado Satisfactoriamente');
        } catch (Exception $e) {
            return RespuestasApi::error($e->getMessage());
        }
    }

}

