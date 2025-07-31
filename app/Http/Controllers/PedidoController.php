<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pedidos\CreatePedidoRequest;
use App\Http\Resources\Pedidos\PedidoResource;
use App\Http\Utilitis\RespuestasApi;
use App\Models\Pedido;
use App\Models\Producto;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index(): JsonResponse
    {
        $pedidos = (Pedido::all()->isEmpty()) ? 'Tabla vacia' : PedidoResource::collection(Pedido::all());
        return RespuestasApi::success($pedidos, 'Listado de Pedidos');
    }

    public function store(CreatePedidoRequest $request): JsonResponse
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $total = 0;
            $detallesData = [];

            // Primero calculamos el total recorriendo los detalles
            foreach ($data['detalles'] as $detalle) {
                $producto = Producto::findOrFail($detalle['producto_id']);
                $subtotal = $producto->precio * $detalle['cantidad'];
                $total += $subtotal;

                $detallesData[] = [
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $subtotal,
                ];
            }

            // Crear el pedido con el total calculado
            $pedido = Pedido::create([
                'user_id' => $data['user_id'],
                'locacion_id' => $data['locacion_id'],
                'total' => $total,
                'metodo_pago_id' => $data['metodo_pago_id'],
                'estado_id' => $data['estado_id'],
                'canal_venta_id' => $data['canal_venta_id'],
                'caja_id' => $data['caja_id'] ?? null,
            ]);

            // Crear los detalles (de nuevo traemos los productos)
            foreach ($detallesData as $detalleData) {
                $pedido->detalles()->create($detalleData);
            }

            DB::commit();

            // return response()->json([
            //     'status' => true,
            //     'message' => 'Pedido creado correctamente',
            //     'data' => new PedidoResource($pedido->load('detalles.producto'))
            // ], 201);
            return RespuestasApi::success(new PedidoResource($pedido->load('detalles.producto')), 'Pedido Creado Satisfactoriamente');
        } catch (Exception $e) {
            DB::rollBack();
            // return response()->json([
            //     'status' => false,
            //     'message' => 'Error al crear el pedido',
            //     'error' => $e->getMessage()
            // ], 500);
            return RespuestasApi::error('Error al Crear el Pedido', $e->getMessage());
        }
    }


    public function show(string $id): JsonResponse
    {
        try {
            $pedido = Pedido::with('detalles.producto', 'usuario', 'locacion', 'canalVenta', 'metodoPago', 'caja', 'estadoPedido')->findOrFail($id);
            // return response()->json([
            //     'status' => true,
            //     'data' => new PedidoResource($pedido)
            // ]);
            return RespuestasApi::success(new PedidoResource($pedido), 'Pedido Consultado Satisfactoriamente');
        } catch (Exception $e) {
            // return response()->json([
            //     'status' => false,
            //     'message' => 'Error al obtener el pedido',
            //     'error' => $e->getMessage()
            // ], 500);
            return RespuestasApi::error('Error al Consultar el Pedido', $e->getMessage());
        }
    }
}
