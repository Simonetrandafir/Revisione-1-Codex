<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndirizziResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return $this->getCampi();
    }
    //---------------------PROTECTED---------------------------------------
    protected function getCampi(){
        return [
            'idTipoIndirizzo'=>$this->idTipoIndirizzo,
            'idContatto'=>$this->idContatto,
            'idNazione'=>$this->idNazione,
            'idComuneItalia'=>$this->idComuneItalia,
            'preferito'=>$this->preferito,
            'cap'=>$this->cap,
            'indirizzo'=>$this->indirizzo,
            'civico'=>$this->civico,
            'citta'=>$this->citta,
            'altro_1'=>$this->altro_1,
            'altro_2'=>$this->altro_2,
        ];
    }
}
