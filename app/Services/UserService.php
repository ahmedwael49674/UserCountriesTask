<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Validators\UserValidator;
use Illuminate\Support\Collection;
use App\Repositories\UserRepository;

class UserService
{
    protected $repository;
    protected $validator;


    public function __construct(UserRepository $userRepository, UserValidator $userValidator)
    {
        $this->repository = $userRepository;
        $this->validator  = $userValidator;
    }

    /**
    * get all active users with country filter
    *
    * @param Request $request
    *
    * @return Collection
    */
    public function index(Request $request):Collection
    {
        $users = $this->repository->index($request->country_id);

        return $users;
    }

    /**
    * delete given user if has no details
    *
    * @param User $user
    *
    * @return void
    */
    public function delete(User $user):void
    {
        $this->validator->canBeDeleted($user);
        $this->repository->delete($user);
    }
}
