<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->showResource();
    }

        //---------------------PROTECTED---------------------------------------
        protected function showResource(){
            return [
                'idCredito'=>$this->idCredito,
                'idContatto'=>$this->idContatto,
                'credito'=>$this->credito,
                'updated_at'=>$this->updated_at
            ];
        }
}
