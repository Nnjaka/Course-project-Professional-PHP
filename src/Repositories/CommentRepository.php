<?php

namespace App\Repositories;

use App\Classes\Comment\Comment;
use App\Repositories\CommentRepositoryInterface;
use App\Exceptions\CommentNotFoundException;
use PDOStatement;
use PDO;
use App\Repositories\EntityRepository;
use App\Classes\EntityInterface;

class CommentRepository extends EntityRepository implements CommentRepositoryInterface
{
    /**
     * @param EntityInterface $entity
     * @return void
     */
    public function save(EntityInterface $entity): void
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
