<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SerieTvResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->getSerieTv();
    }


    // PROTECTED //
    protected function getSerieTv()
    {
        return [
            'idSerieTv' => $this->idSerieTv,
            'idCategoria' => $this->idCategoria,
            'categoria'=>$this->categoria,
            'idGenere'=>$this->idGenere,
            'genere'=>$this->genere,
            'titolo' => $this->titolo,
            'trama' => $this->trama,
            'totStagioni' => $this->totStagioni,
            'nEpisodi' => $this->nEpisodi,
            'regista' => $this->regista,
            'attori' => $this->attori,
            'annoInizio' => $this->annoInizio,
            'annoFine' => $this->annoFine,
            'files'=>$this->files,
        ];
    }
}
