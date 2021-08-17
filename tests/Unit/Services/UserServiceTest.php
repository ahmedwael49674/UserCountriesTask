<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Validators\UserValidator;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * should call UserRepository->index()
     *
     * @return void
     */
    public function test_user_service_index()
    {
        $request             = new Request();
        $request->country_id = 1;
        
        $this->mock(UserRepository::class, function ($mock) use ($request) {
            $mock->shouldReceive('index')
                ->once()
                ->with($request->country_id);
        });

        $this->app->get(UserService::class)->index($request);
    }

    /**
     * should call UserRepository->delete()
     *
     * @return void
     */
    public function test_user_service_delete()
    {
        $user                = User::factory()->create();
        
        $this->partialMock(UserRepository::class, function ($mock) {
            $mock->shouldReceive('delete')
                ->once();
        });
        
        $this->partialMock(UserValidator::class, function ($mock) {
            $mock->shouldReceive('canBeDeleted')
                ->once();
        });

        $this->app->get(UserService::class)->delete($user);
    }
}
