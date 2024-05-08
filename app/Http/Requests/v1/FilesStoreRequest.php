<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class FilesStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'idRecord'=>'integer',
            'tabella'=>'string|max:45',
            'nome'=>'required|string|max:255',
            'size'=>'required|integer',
            'posizione'=>'required|string|max:255',
            'ext'=>'required|string|max:6',
            'descrizione'=>'string|max:45',
            'formato'=>'string|max:45',
        ];
    }
}
