<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class EpisodiStoreRequest extends FormRequest
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
            'idSerieTv'=>'required|integer',
            'titolo'=>'required|string|max:45',
            'trama'=>'required|string',
            'stagione'=>'required|integer',
            'episodio'=>'required|integer',
            'durata'=>'required|integer',
            'anno'=>'required|integer',
            'visualizzato'=>'string|max:1',

        ];
    }
}
