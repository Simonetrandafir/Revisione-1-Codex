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
                'idCategoria'=>$this->idCategoria,
                'categoria'=>$this->categoria,
                'idGenere'=>$this->idGenere,
                'genere'=>$this->genere,
                'titolo'=>$this->titolo,
                'trama'=>$this->trama,
                'durataMin'=>$this->durataMin,
                'annoUscita'=>$this->annoUscita,
                'regista'=>$this->regista,
                'attori'=>$this->attori,
                'files'=>$this->files,
            ];
        }
}
