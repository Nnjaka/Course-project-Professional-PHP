<?php

namespace App\Repositories;

use App\Classes\Article\Article;
use App\Repositories\ArticleRepositoryInterface;
use App\Exceptions\ArticleNotFoundException;
use PDO;
use PDOStatement;
use App\Repositories\EntityRepository;

class ArticleRepository extends EntityRepository implements ArticleRepositoryInterface
{
    /**
     * @throws \Exception
     */
    public function get(int $id): Article
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM articles WHERE id = :id'
        );

        $statement->execute([
            ':id' => (string)$id,
        ]);

        return $this->getArticle($statement, $id);
    }

    public function getArticle(PDOStatement $statement, int $id): Article
    {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if (!$result) {
            throw new ArticleNotFoundException('Статья не найдена');
        }

        return new Article($result->author_id, $result->header, $result->text);
    }
}
