<?php

namespace App\Repositories;

use App\Classes\Article\Article;

interface ArticleRepositoryInterface
{
    public function get(int $id): Article;
}
