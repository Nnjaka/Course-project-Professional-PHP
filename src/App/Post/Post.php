<?php

namespace App\Post;

class Post
{
    public function __construct(
        private int $id,
        private int $autor_id,
        private string $header,
        private string $text
    ) {
    }

    public function __toString()
    {
        return $this->header . ' >>> ' . $this->text;
    }
}
