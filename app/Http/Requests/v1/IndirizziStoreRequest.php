<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndirizziStoreRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'idTipoIndirizzo'=>'required|integer',
            'idContatto'=>'required|integer',
            'idNazione'=>'required|integer',
            'idComuneItalia'=>'required|integer',
            'preferito'=> 'string|max:1',
            'cap'=>'integer',
            'indirizzo'=>'required|string|max:255',
            'civico'=>'required|string|max:15',
            'citta'=>'required|string|max:255',
            'lat'=> 'numeric|max:8.2',
            'lng'=> 'numeric|max:8.2',
            'altro_1'=>'string|max:45',
            'altro_2'=>'string|max:45',
        ];
    }
}
