<?php

namespace App\Http\Resources;

use App\Http\Resources\UserDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = [
            'id'                        => $this->id,
            'email'                     => $this->email,
            'active'                    => $this->active,
        ];

        $mergeDetails = $this->relationLoaded("details");
        if ($mergeDetails) {
            $details = ['details' => new UserDetailsResource($this->details)];
            return array_merge($user, $details);
        }

        return $user;
    }
}
