<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\UserDetail;
use App\Repositories\UserDetailsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserDetailsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * should update user details
     *
     * @return void
     */
    public function test_user_details_repository_update()
    {
        $userDetail = UserDetail::factory()->create();
        $response   = $this->app->get(UserDetailsRepository::class)->update($userDetail, ['first_name' => 'mark', "last_name" => 'henry']);

        $this->assertDatabaseHas("user_details", [
            "id"            => $userDetail->id,
            'first_name'    => 'mark',
            "last_name"     => 'henry'
        ]);
    }
}
