<?php

declare(strict_types=1);

namespace App\Academy\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del colegio es obligatorio.',
            'name.string'   => 'El nombre debe ser texto.',
            'name.min'      => 'El nombre debe tener al menos 3 caracteres.',
            'name.max'      => 'El nombre no puede superar 255 caracteres.',
        ];
    }
}
