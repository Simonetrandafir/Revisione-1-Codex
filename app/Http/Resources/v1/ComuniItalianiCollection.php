<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ComuniItalianiCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }

    //---------------------PROTECTED--------------------------------------------------
    protected function getCampi($item) {
            // 'idComuneItalia',
            // 'nome',
            // 'regione',
            // 'metropolitana',
            // 'provincia',
            // 'siglaAuto',
            // 'codCatastale',
            // 'capoluogo',
            // 'multiCap',
            // 'cap',
            // 'capInizio',
            // 'capFine',
        return [
            'idComuneItalia' => $item["idComuneItalia"],
            'nome' => $item["nome"],
            'regione' => $item["regione"],
            'metropolitana' => $item["metropolitana"],
            'provincia' => $item["provincia"],
            'siglaAuto' => $item["siglaAuto"],
            'codCatastale' => $item["codCatastale"],
            'capoluogo' => $item["capoluogo"],
            'multiCap' => $item["multiCap"],
            'cap' => $item["cap"],
            'capInizio' => $item["capInizio"],
            'capFine' => $item["capFine"],
        ];
    }
}
