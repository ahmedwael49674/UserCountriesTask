<?php

namespace App\Validators;

use App\Models\User;

class UserValidator
{

    /**
    * should includes all requires delete validation steps
    *
    * @param User $user
    *
    * @return void
    */
    public function canBeDeleted(User $user):void
    {
        $this->hasUserDetails($user);
    }

    /**
    * validate that given user has no details or throw 422
    *
    * @param User $user
    *
    * @return void
    */
    public function hasUserDetails(User $user):void
    {
        if ($user->details()->exists()) {
            abort(422, "id => Given user have details and can't be deleted.");
        }
    }
}
