<?php

declare(strict_types=1);

namespace App\Builder;

use App\Entity\Post;
use App\Form\PostForm;

final class PostBuilder
{
    public function build(Post $post, PostForm $form): Post
    {
        $post->setTitle($form->getTitle());
        $post->setContent($form->getText());
        $post->setStatus($form->getStatus());

        return $post;
    }
}
