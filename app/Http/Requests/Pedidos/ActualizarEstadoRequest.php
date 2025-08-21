<?php

namespace App\Http\Requests\Pedidos;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarEstadoRequest extends FormRequest
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
            'estado_id' => 'required|integer|exists:estado_pedidos,id',
        ];
    }
}
