<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\User;
use App\Services\UserDetailsService;
use App\Validators\UserDetailsValidator;
use App\Repositories\UserDetailsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserDetailsValidatorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * should call this->canBeUpdated()
     *
     * @return void
     */
    public function test_user_details_validator_canBeUpdated()
    {
        $user = User::factory()->hasDetails()->create();
        
        $this->partialMock(UserDetailsValidator::class, function ($mock) use ($user) {
            $mock->shouldReceive('hasUserDetails')
                ->once()
                ->with($user);
        });

        $this->app->get(UserDetailsValidator::class)->canBeUpdated($user);
    }

    /**
     * should  throw 422 if user doesn't have details
     * should do nothing if user has details
     *
     * @return void
     */
    public function test_user_details_validator_hasUserDetails()
    {
        $user       = User::factory()->hasDetails()->create();
        $validator  = $this->app->get(UserDetailsValidator::class);
        $validator->hasUserDetails($user); //do nothing

        $userwithoutDetails     = User::factory()->create();
        try {
            $validator->hasUserDetails($userwithoutDetails); //throw 422
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            $this->assertEquals(422, $e->getStatusCode());
            $this->assertEquals("user_id => Given user doesn't have details.", $e->getMessage());
        }
    }
}
