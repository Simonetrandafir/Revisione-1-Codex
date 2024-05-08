<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->showGenere();
    }

        //---------------------PROTECTED---------------------------------------
        protected function showGenere(){
            return[
                'idFilm'=>$this->idFilm,
                'titolo'=>$this->titolo,
                'trama'=>$this->trama,
                'durata'=>$this->durataMin,
                'anno'=>$this->annoUscita,
                'regista'=>$this->regista,
                'attori'=>$this->attori,
            ];
        }
}
