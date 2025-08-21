<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class registrarVentaRequest extends FormRequest
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
            'metodo_pago_id' => 'required|exists:metodo_pagos,id',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ];
    }
    public function messages(): array
    {
        return [
            'metodo_pago_id.required' => 'El método de pago es obligatorio.',
            'metodo_pago_id.exists' => 'El método de pago seleccionado no existe.',
            'productos.required' => 'Debe agregar al menos un producto.',
            'productos.array' => 'El formato de productos no es válido.',
            'productos.*.producto_id.required' => 'El producto es obligatorio.',
            'productos.*.producto_id.exists' => 'El producto seleccionado no existe.',
            'productos.*.cantidad.required' => 'Debe especificar la cantidad.',
            'productos.*.cantidad.integer' => 'La cantidad debe ser un número entero.',
            'productos.*.cantidad.min' => 'La cantidad debe ser al menos 1.',
        ];
    }
}
