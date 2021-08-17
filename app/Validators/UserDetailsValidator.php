<?php

namespace App\Validators;

use App\Models\User;

class UserDetailsValidator
{

    /**
    * should includes all requires update validation steps
    *
    * @param User $user
    *
    * @return void
    */
    public function canBeUpdated(User $user):void
    {
        $this->hasUserDetails($user);
    }

    /**
    * validate that given user has details or throw 422
    *
    * @param User $user
    *
    * @return void
    */
    public function hasUserDetails(User $user):void
    {
        if (blank($user->details)) {
            abort(422, "user_id => Given user doesn't have details.");
        }
    }
}
