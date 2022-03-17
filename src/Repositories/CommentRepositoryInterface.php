<?php

namespace App\Repositories;

use App\Classes\Comment\Comment;

interface CommentRepositoryInterface
{
    public function get(int $id): Comment;
}
