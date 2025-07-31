<?php

namespace App\Http\Requests;

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
            'calle' => 'required|string|max:100',
            'numero' => 'required|string|max:20',
            'barrio' => 'required|string|max:100',
            'referencia' => 'nullable|string',
        ];
    }
}
