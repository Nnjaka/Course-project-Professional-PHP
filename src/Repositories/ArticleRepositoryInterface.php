<?php

namespace App\Repositories;

use App\Classes\Article\Article;
use PDOStatement;

interface ArticleRepositoryInterface
{
    public function get(int $id): Article;
    public function getArticle(PDOStatement $statement, int $id): Article;
}
