<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class RegistraRequest extends FormRequest
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
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'sesso' => 'nullable|in:0,1,2',
            'dataNascita' => 'required|date',
            'nazione' => 'required|integer',
            'citta' => 'required|string|max:255',
            'provinciaNascita' => 'required|string|max:255',
            'indirizzo' => 'required|string|max:255',
            'civico' => 'required|string|max:255',
            'cittadinanza' => 'required|string|max:255',
            'codFiscale' => 'nullable|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'psw' => 'required|string|min:8',
            'pswConfirm' => 'required|string|min:8',
            'preferito' => 'nullable|boolean',
            'checkDati' => 'required|boolean',
        ];
    }
}
