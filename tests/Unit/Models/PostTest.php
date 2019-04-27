<?php

namespace Tests\Unit\Models;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testUserRelation()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'user_id' => $user,
        ]);

        $this->assertEquals($user->toArray(), $post->author->toArray());
    }
}
