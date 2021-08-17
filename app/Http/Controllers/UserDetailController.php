<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserDetailsService;

class UserDetailController extends Controller
{
    protected $service;

    public function __construct(UserDetailsService $userDetailsService)
    {
        $this->service = $userDetailsService;
    }

    /**
    * update user details if exists
    *
    * @param \App\Http\Requests\UpdateUserDetails $request
    *
    * @return \App\Http\Resources\UserResource
    */
    public function update(\App\Http\Requests\UpdateUserDetails $request, User $user)
    {
        $user = $this->service->update($request, $user);

        return new \App\Http\Resources\UserResource($user);
    }
}
