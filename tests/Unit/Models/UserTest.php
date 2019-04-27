<?php

namespace Tests\Unit\Models;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testGetGravatar()
    {
        $user = factory(User::class)->create();

        $this->assertSame(
            'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email))),
            $user->getGravatar()
        );
    }
}
