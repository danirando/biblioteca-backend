<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *

     */
    // app/Http/Resources/BookResource.php
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'titolo'      => $this->titolo, // Mantieni i nomi originali se il frontend li usa già
            'autore'      => $this->autore,
            'anno'        => $this->anno,
            'genere'      => $this->genere,
            'descrizione' => $this->descrizione,
        ];
    }
}
