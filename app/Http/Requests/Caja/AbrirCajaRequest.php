<?php

namespace App\Http\Requests\Caja;

use Illuminate\Foundation\Http\FormRequest;

class AbrirCajaRequest extends FormRequest
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
            'monto_apertura' => 'nullable|numeric|min:0',
        ];
    }
}
