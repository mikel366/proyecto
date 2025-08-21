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
            'locacion_id' => 'required|exists:locacions,id',
            'metodo_pago_id' => 'required|exists:metodo_pagos,id',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ];
    }
}
