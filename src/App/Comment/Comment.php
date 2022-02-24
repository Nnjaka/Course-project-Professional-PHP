<?php

namespace App\Comment;

class Comment
{
    public function __construct(
        private int $id,
        private int $autor_id,
        private int $article_id,
        private string $text
    ) {
    }

    public function __toString()
    {
        return $this->text;
    }
}
