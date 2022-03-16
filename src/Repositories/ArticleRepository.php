<?php

namespace App\Repositories;

use App\Classes\Article\Article;
use App\Repositories\ArticleRepositoryInterface;
use App\Exceptions\ArticleNotFoundException;
use PDO;
use PDOStatement;
use App\Repositories\EntityRepository;
use App\Classes\EntityInterface;

class ArticleRepository extends EntityRepository implements ArticleRepositoryInterface
{

    /**
     * @param EntityInterface $entity
     * @return void
     */
    public function save(EntityInterface $entity): void
    {
        /**
         * @var Article $entity
         */
        $statement =  $this->connector->getConnection()
            ->prepare("INSERT INTO articles (author_id, header, text) 
                VALUES (:author_id, :header, :text)");

        $statement->execute(
            [
                ':author_id' => $entity->getAuthorId(),
                ':header' => $entity->getHeader(),
                ':text' => $entity->getText(),
            ]
        );
    }


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

    private function getArticle(PDOStatement $statement, int $id): Article
    {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if ($result === false) {
            throw new ArticleNotFoundException(
                sprintf("Cannot find article with id: %s", $id)
            );
        }

        return new Article($result->authorId, $result->header, $result->text);
    }

    public function delete(int $id): void
    {
        $statement = $this->connector->getConnection()->prepare(
            'DELETE FROM articles WHERE id = :id'
        );

        $statement->execute(
            [
                ':id' => (string)$id
            ]
        );
    }
}
