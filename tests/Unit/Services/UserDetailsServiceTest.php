<?php

namespace Tests\Unit\Services;

use App\Models\User;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use App\Services\UserDetailsService;
use App\Validators\UserDetailsValidator;
use App\Repositories\UserDetailsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserDetailsServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * should call UserDetailsRepository->update()
     *
     * @return void
     */
    public function test_user_details_service_update()
    {
        $user                = User::factory()->hasDetails()->create();
        $request             = new Request();
        $request->first_name = "mark";
        
        $this->mock(UserDetailsRepository::class, function ($mock) {
            $mock->shouldReceive('update')
                ->once();
        });
        
        $this->partialMock(UserDetailsValidator::class, function ($mock) {
            $mock->shouldReceive('canBeUpdated')
                ->once();
        });

        $this->app->get(UserDetailsService::class)->update($request, $user);
    }
}
