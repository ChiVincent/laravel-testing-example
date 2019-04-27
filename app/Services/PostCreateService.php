<?php

namespace App\Services;

use App\Post;
use App\User;

class PostCreateService
{
    public function post(User $author, string $title, string $content): Post
    {
        if (! $author->canPostArticle()) {
            throw new \Exception('您的芝麻信用点数不足，请充值，亲');
        }

        return Post::create([
            'user_id' => $author->id,
            'title' => $title,
            'content' => $content,
        ]);
    }
}
