<?php

namespace App\Repositories;

use App\Models\UserDetail;

class UserDetailsRepository
{

    /**
    * update given user details with given attributes
    *
    * @param UserDetail $userDetails
    * @param array $attributes
    *
    * @return UserDetail
    */
    public function update(UserDetail $userDetails, array $attributes):UserDetail
    {
        $userDetails->update($attributes);
        
        return $userDetails;
    }
}
