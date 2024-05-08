<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class ContattoStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        return [
            "idStato" => "required|integer",
            "nome" => "required|string|max:45",
            "cognome" => "required|string|max:45",
            "sesso" => "integer",
            "codFiscale" =>'string|max:45',
            "partitaIva" => 'string|max:45',
            "cittadinanza" => 'string|max:45',
            "idNazione" => 'string|max:45',
            "cittaNascita" => 'string|max:45',
            "provinciaNascita"=> 'string|max:45',
            "dataNascita"=> "string|max:255",
        ];
    }
}
