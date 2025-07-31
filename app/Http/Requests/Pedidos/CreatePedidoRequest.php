<?php

namespace App\Http\Requests\Pedidos;

use Illuminate\Foundation\Http\FormRequest;

class CreatePedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'locacion_id' => 'required|exists:locacions,id',
            'metodo_pago_id' => 'required|exists:metodo_pagos,id',
            'estado_id' => 'required|exists:estado_pedidos,id',
            'canal_venta_id' => 'required|exists:canal_ventas,id',
            'caja_id' => 'nullable|exists:cajas,id',
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
        ];
    }
}
