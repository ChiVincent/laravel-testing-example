<?php

namespace App\Services;

use App\Post;
use App\User;

class PostCreateService
{
    public function post(User $author, string $title, string $content): Post
    {
        return Post::create([
            'user_id' => $author->id,
            'title' => $title,
            'content' => $content,
        ]);
    }
}
