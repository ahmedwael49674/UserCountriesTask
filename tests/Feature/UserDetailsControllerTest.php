<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserDetailsControllerTest extends TestCase
{
    use RefreshDatabase;


    /******************************** update **********************************/

    /**
     * Can't update user has details should throw 422
     *
     * @return void
     */
    public function test_user_details_controller_update_user_has_no_details()
    {
        $user = User::factory()->create();
        
        $this->patchJson("api/v1/users/{$user->id}/details", ["first_name" => "marco"])
            ->assertJson(["message" => "user_id => Given user doesn't have details."])
            ->assertStatus(422);
    }

    /**
     * countries provided by country seeder have ids from 1 to 6
     * should throw 422
     *
     * @return void
     */
    public function test_user_details_controller_update_user_country_with_non_vaid_country()
    {
        $user = User::factory()->create();
        
        $this->patchJson("api/v1/users/{$user->id}/details", ["citizenship_country_id" => 100])
            ->assertStatus(422);
    }

    /**
     * should throw 422
     *
     * @return void
     */
    public function test_user_details_controller_update_non_existing_user()
    {
        $this->patchJson("api/v1/users/1/details", ["first_name" => "marco"])
            ->assertStatus(404);
    }

    /**
     * should update user
     *
     * @return void
     */
    public function test_user_controller_delete_user_has_details()
    {
        $user = User::factory()->hasDetails()->create();
        
        //test update first_name
        $this->patchJson("api/v1/users/{$user->id}/details", ["first_name" => "marco"])
            ->assertJsonStructure([
                "data" =>[
                    "id",
                    "email",
                    "active",
                    "details" => [
                        "first_name",
                        "last_name",
                        "phone_number",
                        "citizenship_country_id"
                    ]
                ]
            ])->assertJsonFragment([
                "first_name" => "marco"
            ])->assertOk();

        $this->assertDatabaseHas("user_details", [
            "user_id" => $user->id,
            "first_name" => "marco"
        ]);
        
        //test update last_name
        $this->patchJson("api/v1/users/{$user->id}/details", ["last_name" => "John"])
            ->assertJsonFragment([
                "last_name"  => "John"
            ])->assertOk();

        $this->assertDatabaseHas("user_details", [
            "user_id" => $user->id,
            "last_name" => "John"
        ]);
        
        //test update first_name
        $this->patchJson("api/v1/users/{$user->id}/details", ["phone_number" => "5161984988"])
            ->assertJsonFragment([
                "phone_number" => "5161984988"
            ])->assertOk();

        $this->assertDatabaseHas("user_details", [
            "user_id" => $user->id,
            "phone_number" => "5161984988"
        ]);
        
        //test update citizenship_country_id
        $this->patchJson("api/v1/users/{$user->id}/details", ["citizenship_country_id" => 2])
            ->assertJsonFragment([
                "citizenship_country_id" => 2
            ])->assertOk();
            
        $this->assertDatabaseHas("user_details", [
            "user_id"                => $user->id,
            "citizenship_country_id" => 2
        ]);
    }
}
