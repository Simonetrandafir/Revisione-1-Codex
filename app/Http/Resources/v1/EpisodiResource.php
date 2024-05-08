<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EpisodiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->getEpisodi();
    }

    // PROTECTED //
    protected function getEpisodi()
    {
        return [
            'idEpisodio' => $this->idEpisodio,
            'idSerieTv' => $this->idSerieTv,
            'titolo' => $this->titolo,
            'trama' => $this->trama,
            'stagione' => $this->stagione,
            'episodio' => $this->episodio,
            'durata' => $this->durata,
            'anno' => $this->anno,
        ];
    }
}
