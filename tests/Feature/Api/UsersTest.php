<?php

namespace Tests\Feature\Api;

use App\Users;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUsersPublicStructureCorrectly()
    {
        $user = factory(Users::class)->create();
        $headers = ['Content-Type' => "application/json"];
        $this->json('GET', '/api/users/'.$user->id, [],$headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'telegram',
                'default_currency_id',
                'min_rank',
                'rank',
                'deals_count'
            ]);
    }
}