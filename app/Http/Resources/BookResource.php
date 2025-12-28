<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->titolo, // Posso rinominare i campi per l'esterno
            'author'      => $this->autore,
            'year'        => $this->anno,
            'genre'       => $this->genere,
            'description' => $this->descrizione,
            'created_at'  => $this->created_at->format('d-m-Y'), // Formatto la data
        ];
    }
}
