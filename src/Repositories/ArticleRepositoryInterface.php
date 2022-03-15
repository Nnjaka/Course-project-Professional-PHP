<?php

namespace App\Repositories;

use App\Classes\Article\Article;

interface ArticleRepositoryInterface
{
    public function save(Article $entity): void;
    public function get(int $id): Article;
}
