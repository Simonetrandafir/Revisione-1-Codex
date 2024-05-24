<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NazioniResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return $this->getNazione();
    }


    // PROTECTED //
    protected function getNazione()
    {
        return [
            'idNazione' => $this->idNazione,
            'nome' => $this->nome,
            'continente' => $this->continente,
            'iso' => $this->iso,
            'iso3' => $this->iso3,
            'prefissoTel' => $this->prefissoTel,
        ];
    }

}
