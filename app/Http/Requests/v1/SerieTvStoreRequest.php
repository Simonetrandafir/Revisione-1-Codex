<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class SerieTvStoreRequest extends FormRequest
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
            'idCategoria'=>'required|integer',
            'idGenere'=>'required|integer',
            'titolo'=>'required|string|max:45',
            'trama'=>'required|string',
            'totStagioni'=>'required|integer',
            'nEpisodi'=>'required|integer',
            'regista'=>'required|string|max:45',
            'attori'=>'required|string|max:255',
            'annoInizio'=>'required|integer',
            'annoFine'=>'integer',
            'visualizzato'=>'string|max:1',
            'idFile'=>'integer',
            'idVideo'=>'integer',
        ];
    }
}
