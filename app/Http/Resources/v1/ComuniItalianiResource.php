<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComuniItalianiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->showComuniItaliani();
    }

        //---------------------PROTECTED---------------------------------------
        protected function showComuniItaliani(){
            return [
                'idComuneItalia'=>$this->idComuneItalia,
                'nome'=>$this->nome,
                'regione'=>$this->regione,
                'metropolitana'=>$this->metropolitana,
                'provincia'=>$this->provincia,
                'siglaAuto'=>$this->siglaAuto,
                'codCatastale'=>$this->codCatastale,
                'capoluogo'=>$this->capoluogo,
                'multiCap'=>$this->multiCap,
                'cap'=>$this->cap,
                'capInizio'=>$this->capInizio,
                'capFine'=>$this->capFine,

            ];
        }
}
