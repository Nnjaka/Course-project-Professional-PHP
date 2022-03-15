<?php

namespace App\Repositories;

use App\Classes\Article\Article;
use App\Repositories\ArticleRepositoryInterface;
use App\Connections\SqlLiteConnector;
use App\Connections\SqlLiteConnectorInterface;
use App\Exceptions\ArticleNotFoundException;
use PDO;
use PDOStatement;

class ArticleRepository implements ArticleRepositoryInterface
{
    private SqlLiteConnectorInterface $connector;

    public function __construct(SqlLiteConnectorInterface $sqlLiteConnector = null)
    {
        $this->connector = $sqlLiteConnector ?? new SqlLiteConnector();
    }

    /**
     * @param Article $entity
     * @return void
     */
    public function save(Article $entity): void
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