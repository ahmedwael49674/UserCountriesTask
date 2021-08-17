<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\User;
use App\Validators\UserValidator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserValidatorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * should call this->hasUserDetails()
     *
     * @return void
     */
    public function test_user_validator_canBeDeleted()
    {
        $user = User::factory()->create();
        
        $this->partialMock(UserValidator::class, function ($mock) use ($user) {
            $mock->shouldReceive('hasUserDetails')
                ->once()
                ->with($user);
        });

        $this->app->get(UserValidator::class)->canBeDeleted($user);
    }

    /**
     * should  throw 422 if user has details
     * should do nothing if user has no details
     *
     * @return void
     */
    public function test_user_validator_hasUserDetails()
    {
        $user       = User::factory()->create();
        $validator  = $this->app->get(UserValidator::class);
        $validator->hasUserDetails($user); //do nothing

        $userwithoutDetails     = User::factory()->hasDetails()->create();
        try {
            $validator->hasUserDetails($userwithoutDetails); //throw 422
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            $this->assertEquals(422, $e->getStatusCode());
            $this->assertEquals("id => Given user have details and can't be deleted.", $e->getMessage());
        }
    }
}
