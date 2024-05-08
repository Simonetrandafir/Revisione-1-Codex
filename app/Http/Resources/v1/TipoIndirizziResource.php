<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TipoIndirizziResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->getTipoIndirizzi();
    }


    // PROTECTED //
    protected function getTipoIndirizzi()
    {
        return [
            'idTipoIndirizzo' => $this->idTipoIndirizzo,
            'nome' => $this->nome,
        ];
    }
}
