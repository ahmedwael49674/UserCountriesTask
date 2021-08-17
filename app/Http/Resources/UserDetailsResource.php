<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'first_name'                => $this->first_name,
            'last_name'                 => $this->last_name,
            'phone_number'              => $this->phone_number,
            'citizenship_country_id'    => $this->citizenship_country_id,
        ];
    }
}
