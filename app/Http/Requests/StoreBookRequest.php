<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Imposta a true per permettere l'invio
    }

    public function rules(): array
    {
        return [
            'titolo'      => 'required|string|max:255',
            'autore'      => 'required|string|max:255',
            'anno'        => 'required|integer|min:1000|max:' . date('Y'),
            'genere'      => 'required|string|max:100',
            'descrizione' => 'nullable|string',
        ];
    }
}
