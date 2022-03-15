<?php

namespace App\Repositories;

use App\Classes\Comment\Comment;

interface CommentRepositoryInterface
{
    public function save(Comment $entity): void;
    public function get(int $id): Comment;
}
