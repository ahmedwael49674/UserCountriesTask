<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Validators\UserDetailsValidator;
use App\Repositories\UserDetailsRepository;

class UserDetailsService
{
    protected $userDetailsRepository;
    protected $userRepository;
    protected $validator;


    public function __construct(
        UserDetailsRepository $userDetailsRepository,
        UserDetailsValidator $userDetailsValidator,
        UserRepository $userRepository
    ) {
        $this->userDetailsRepository = $userDetailsRepository;
        $this->userRepository        = $userRepository;
        $this->validator             = $userDetailsValidator;
    }

    /**
    * update user details
    *
    * @param Request $request
    *
    * @return User
    */
    public function update(Request $request, User $user):User
    {
        $user->load('details');
        $this->validator->canBeUpdated($user);
        $user->details = $this->userDetailsRepository->update($user->details, $request->only(UserDetail::UpdatableAttributes));
        
        return $user;
    }
}
