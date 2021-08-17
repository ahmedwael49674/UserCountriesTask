<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /******************************** index **********************************/

    /**
     * should return active users
     *
     * @return void
     */
    public function test_user_controller_index()
    {
        $users = User::factory()->count(2)->create();
        User::factory()->notActive()->count(2)->create();

        $this->get("api/v1/users")
            ->assertJsonStructure([
                "data" => [
                    [
                        "id",
                        "email",
                        "active",
                    ]
                ]
            ])->assertJsonFragment([
                "data" => [
                    [
                        "active"    => true,
                        "id"        => $users[0]->id,
                        "email"     => $users[0]->email,
                    ],
                    [
                        "active"    => true,
                        "id"        => $users[1]->id,
                        "email"     => $users[1]->email,
                    ],
                ],
            ])->assertJsonCount(2, 'data')
            ->assertOk();
    }

    /**
     * should return active users with country given code
     *
     * @return void
     */
    public function test_user_controller_index_with_country_filter()
    {
        $users = User::factory()->hasDetails(['citizenship_country_id' => 1])->count(2)->create();
        User::factory()->hasDetails(['citizenship_country_id' => 2])->create();
        User::factory()->hasDetails(['citizenship_country_id' => 3])->create();
        User::factory()->hasDetails(['citizenship_country_id' => 1])->notActive()->count(2)->create();
        
        $this->get("api/v1/users?country_id=1")
            ->assertJsonStructure([
                "data" => [
                    [
                        "id",
                        "email",
                        "active",
                    ]
                ]
            ])->assertJsonFragment([
                "data" => [
                    [
                        "active"    => true,
                        "id"        => $users[0]->id,
                        "email"     => $users[0]->email,
                    ],
                    [
                        "active"    => true,
                        "id"        => $users[1]->id,
                        "email"     => $users[1]->email,
                    ],
                ],
            ])->assertJsonCount(2, 'data')
            ->assertOk();
    }

    /**
     * countries provided by country seeder have ids from 1 to 6
     * should throw 422
     *
     * @return void
     */
    public function test_user_controller_index_country_filter_with_non_valid_country()
    {
        $this->get("api/v1/users?country_id=500")
            ->assertStatus(422);
    }

    /******************************** delete **********************************/

    /**
     * Can't delete user has details should throw 422
     *
     * @return void
     */
    public function test_user_controller_delete_user_has_details()
    {
        $user = User::factory()->hasDetails()->create();
        
        $this->deleteJson("api/v1/users/{$user->id}")
            ->assertJson(["message" => "id => Given user have details and can't be deleted."])
            ->assertStatus(422);
    }

    /**
     * should throw 404
     *
     * @return void
     */
    public function test_user_controller_delete_non_existing_user()
    {
        $this->deleteJson("api/v1/users/1")
            ->assertStatus(404);
    }

    /**
     * should delete user
     *
     * @return void
     */
    public function test_user_controller_delete_user_has_no_details()
    {
        $user = User::factory()->create();

        $this->deleteJson("api/v1/users/{$user->id}")
            ->assertJson(['Given User has been deleted successfully.'])
            ->assertOk();

        $this->assertDatabaseMissing("users", ["id" => $user->id]);
    }
}
