<?php

namespace App\Http\Requests\Locacion;

use Illuminate\Foundation\Http\FormRequest;

class LocacionRequest extends FormRequest
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
            'calle' => 'required|string',
            'numero' => 'required|string',
            'referencia' => 'required|string',
            'barrio' => 'required|string',
            'altitud' => 'required|string',
            'longitud' => 'required|string',
            'is_default' => 'required|boolean',
        ];
    }
}
