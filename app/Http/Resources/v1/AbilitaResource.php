<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AbilitaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->getRuolo();
    }


    // PROTECTED //
    protected function getRuolo()
    {
        return [
            "id"=> $this->idAbilita,
            "nome"=> $this->nome,
            "sku"=> $this->sku,
        ];
    }
}
