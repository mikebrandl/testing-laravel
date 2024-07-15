<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatchFruitRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string',
            'color' => 'sometimes|string',
        ];
    }
}
