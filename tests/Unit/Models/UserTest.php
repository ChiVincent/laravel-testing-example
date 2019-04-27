<?php

namespace Tests\Unit\Models;

use App\Post;
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

    public function testPostsRelation()
    {
        $user = factory(User::class)->create();
        $posts = factory(Post::class, 3)->create([
            'user_id' => $user,
        ]);

        $this->assertEquals($posts->toArray(), $user->posts->toArray());
    }
}
