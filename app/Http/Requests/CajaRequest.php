<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CajaRequest extends FormRequest
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
            'fecha_apertura' => 'required|date',
            'fecha_cierre' => 'nullable|date|after_or_equal:fecha_apertura',
            'monto_apertura' => 'required|numeric|min:0',
            'monto_cierre' => 'nullable|numeric|min:0',
            'estado_caja_id' => 'required|exists:estado_cajas,id',
            'observaciones' => 'nullable|string',
        ];
    }
}