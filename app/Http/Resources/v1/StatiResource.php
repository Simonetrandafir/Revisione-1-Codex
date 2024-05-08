<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->getStati();
    }


    // PROTECTED //
    protected function getStati()
    {
        return [
            "idStato"=> $this->idStato,
            "stato"=> $this->stato,
        ];
    }
}
