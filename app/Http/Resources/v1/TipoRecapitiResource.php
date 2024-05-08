<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TipoRecapitiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->getCampi();
    }


    // PROTECTED //
    protected function getCampi()
    {
        return [
            'idTipoRecapito' => $this->idTipoRecapito,
            'nome' => $this->nome,
        ];
    }
}
