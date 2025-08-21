<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateImagenProductoRequest extends FormRequest
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
            'producto_id' => 'required|exists:productos,id',
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ];
    }
}
