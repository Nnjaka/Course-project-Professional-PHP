<?php

namespace App\Repositories;

use App\Classes\Comment\Comment;
use App\Repositories\CommentRepositoryInterface;
use App\Connections\SqlLiteConnector;
use App\Connections\SqlLiteConnectorInterface;
use App\Exceptions\CommentNotFoundException;
use PDOStatement;
use PDO;

class CommentRepository implements CommentRepositoryInterface
{
    private SqlLiteConnectorInterface $connector;

    public function __construct(SqlLiteConnectorInterface $sqlLiteConnector = null)
    {
        $this->connector = $sqlLiteConnector ?? new SqlLiteConnector();
    }

    /**
     * @param Comment $entity
     * @return void
     */
    public function save(Comment $entity): void
    {
        /**
         * @var Comment $entity
         */
        $statement = $this->connector->getConnection()
            ->prepare("INSERT INTO comments(author_id, article_id, comment) 
                VALUES (:author_id, :article_id, :comment)");

        $statement->execute(
            [
                ':author_id' => $entity->getAuthorId(),
                ':article_id' => $entity->getArticleId(),
                ':comment' => $entity->getComment(),
            ]
        );
    }

    public function get(int $id): Comment
    {
        $statement = $this->connector->getConnection()
            ->prepare("SELECT * FROM comments WHERE id=:id");
        $statement->execute(
            [
                ':id' => (string)$id
            ]
        );

        return $this->getComment($statement, $id);
    }

    public function getComment(PDOStatement $statement, int $id): Comment
    {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if ($result === false) {
            throw new CommentNotFoundException(
                printf("Cannot find comment with id: %s", $id)
            );
        }

        return new Comment($result->authorId, $result->articleId, $result->comment);
    }

    public function delete(int $id): void
    {
        $statement = $this->connector->getConnection()->prepare(
            'DELETE FROM comments WHERE id = :id'
        );

        $statement->execute(
            [
                ':id' => (string)$id
            ]
        );
    }
}
