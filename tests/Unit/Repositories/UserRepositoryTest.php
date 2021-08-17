<?php
namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * should index the users
     *
     * @return void
     */
    public function test_user_repository_index()
    {
        User::factory()->hasDetails(['citizenship_country_id' => 1])->count(2)->create();
        User::factory()->hasDetails(['citizenship_country_id' => 2])->create();
        User::factory()->hasDetails(['citizenship_country_id' => 3])->create();
        User::factory()->hasDetails(['citizenship_country_id' => 1])->notActive()->count(2)->create();
        
        $repository = $this->app->get(UserRepository::class);
        $this->assertEquals($repository->index(null)->count(), 4); //all active users
        $this->assertEquals($repository->index(1)->count(), 2); //active users with country 1
        $this->assertEquals($repository->index(2)->count(), 1);//active users with country 2
    }

    /**
     * should delete the user
     *
     * @return void
     */
    public function test_user_repository_delete()
    {
        $user = User::factory()->create();
        $this->app->get(UserRepository::class)->delete($user);
        $this->assertDatabaseMissing("users", ["id" => $user->id]);
    }
}
