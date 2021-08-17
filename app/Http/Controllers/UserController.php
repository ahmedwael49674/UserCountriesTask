<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    /**
    * Index all active users with country filter
    *
    * @param \App\Http\Requests\IndexUsers $request
    *
    * @return Json
    */
    public function index(\App\Http\Requests\IndexUsers $request)
    {
        $users = $this->service->index($request);

        return new \App\Http\Resources\UserCollection($users);
    }

    /**
    * delete given user if has no details
    *
    * @param User $user
    *
    * @return Json
    */
    public function destroy(User $user)
    {
        $this->service->delete($user);

        return response()->json(['Given User has been deleted successfully.']);
    }
}
