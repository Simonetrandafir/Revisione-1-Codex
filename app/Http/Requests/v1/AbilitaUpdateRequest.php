<?php

namespace App\Http\Requests\v1;

use App\Helpers\AppHelpers;
use Illuminate\Foundation\Http\FormRequest;

class AbilitaUpdateRequest extends AbilitaStoreRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();
        return AppHelpers::aggiornaRegoleHelpers($rules);
    }
}
