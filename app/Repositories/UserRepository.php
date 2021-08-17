<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository
{
    /**
    * get all active users with country filter
    *
    * @param null|string $iso2
    *
    * @return Collection
    */
    public function index(?int $countryId):Collection
    {
        return User::active()
                    ->countryId($countryId)
                    ->get();
    }

    /**
    * delete given user
    *
    * @param User $user
    *
    * @return void
    */
    public function delete(User $user):void
    {
        $user->delete();
    }
}
