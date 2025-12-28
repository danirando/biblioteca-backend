<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titolo'      => 'sometimes|string|max:255',
            'autore'      => 'sometimes|string|max:255',
            'anno'        => 'sometimes|integer|min:1000|max:' . date('Y'),
            'genere'      => 'sometimes|string|max:100',
            'descrizione' => 'nullable|string',
        ];
    }
}
