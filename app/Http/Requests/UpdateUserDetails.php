<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserDetails extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "citizenship_country_id"            => "integer|exists:countries,id",
            "first_name"                        => "string",
            "last_name"                         => "string",
        ];
    }
}
