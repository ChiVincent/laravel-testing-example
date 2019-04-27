<?php

namespace Tests\Unit\Services;

use App\Post;
use App\Services\PostCreateService;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostCreateServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testPost()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->make([
            'user_id' => null,
        ]);

        $service = app(PostCreateService::class);
        $result = $service->post($user, $post->title, $post->content);

        $this->assertInstanceOf(Post::class, $result);
        $this->assertDatabaseHas('posts', [
            'user_id' => $user->id,
            'title' => $post->title,
            'content' => $post->content,
        ]);
    }

    public function testPostButCannotPost()
    {
        $user = $this->mock(User::class);
        $user->shouldReceive('canPostArticle')->once()->andReturn(false);

        $post = factory(Post::class)->make(['user_id' => null]);
        $service = app(PostCreateService::class);

        $this->expectException(\Exception::class);
        $service->post($user, $post->title, $post->content);
    }
}
